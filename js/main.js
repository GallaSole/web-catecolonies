// =========================================================
// Catecolònies · funcions de la web
// =========================================================

// 1. Menú per a mòbil (botó hamburguesa)
const botoMenu = document.querySelector(".boto-menu");
const menu = document.querySelector(".menu");
if (botoMenu && menu) {
  botoMenu.addEventListener("click", () => {
    const obert = menu.classList.toggle("obert");
    botoMenu.setAttribute("aria-expanded", obert);
  });
}

// 2. (Els torns ara tenen sempre les mateixes edats: es canvien directament a index.html)

// 3. FAQ: cercador i filtres per categoria
const cercador = document.querySelector(".cercador");
const filtres = document.querySelectorAll(".faq-filtres button");
const preguntes = document.querySelectorAll(".faq details");
let categoriaActiva = "totes";

function filtraFaq() {
  const text = cercador ? cercador.value.toLowerCase().trim() : "";
  preguntes.forEach((p) => {
    const coincideixText = p.textContent.toLowerCase().includes(text);
    const coincideixCat = categoriaActiva === "totes" || p.dataset.cat === categoriaActiva;
    p.style.display = coincideixText && coincideixCat ? "" : "none";
  });
}

if (cercador) cercador.addEventListener("input", filtraFaq);
filtres.forEach((b) =>
  b.addEventListener("click", () => {
    categoriaActiva = b.dataset.cat;
    filtres.forEach((x) => x.classList.toggle("actiu", x === b));
    filtraFaq();
  })
);

// 4. Any actual al peu de pàgina
document.querySelectorAll("[data-any-actual]").forEach((el) => (el.textContent = new Date().getFullYear()));

// 5. Compte enrere fins a l'1 d'agost (les KT són de l'1 al 10 d'agost)
const compte = document.querySelector("[data-compte]");
if (compte) {
  const el = (n) => compte.querySelector(`[data-${n}]`);
  const dosDigits = (n) => String(n).padStart(2, "0");

  function actualitzaCompte() {
    const ara = new Date();
    let any = ara.getFullYear();
    const inici = new Date(any, 7, 1, 9, 0, 0);   // 1 d'agost, 9 h (mes 7 = agost)
    const final = new Date(any, 7, 11, 0, 0, 0);  // fins al 10 d'agost inclòs

    if (ara >= inici && ara < final) {
      el("compte-titol").textContent = "Ja som de colònies! 🎒";
      el("compte-text").textContent = "Escolta'ns a Ràdio Arenys de Munt (107 FM).";
      ["dies", "hores", "minuts", "segons"].forEach((n) => (el(n).textContent = "0"));
      return;
    }
    const objectiu = ara >= final ? new Date(any + 1, 7, 1, 9, 0, 0) : inici;
    const diff = objectiu - ara;
    el("compte-titol").textContent = `Falten ${Math.floor(diff / 86400000)} dies per a les KT ${objectiu.getFullYear()}!`;
    el("compte-text").textContent = "Sortim l'1 d'agost. Ja tens la motxilla a punt?";
    el("dies").textContent = Math.floor(diff / 86400000);
    el("hores").textContent = dosDigits(Math.floor(diff / 3600000) % 24);
    el("minuts").textContent = dosDigits(Math.floor(diff / 60000) % 60);
    el("segons").textContent = dosDigits(Math.floor(diff / 1000) % 60);
  }
  actualitzaCompte();
  setInterval(actualitzaCompte, 1000);
}

// 6. KT Fotos: el vídeo només es carrega quan cliques (la pàgina va més ràpida)
document.querySelectorAll("[data-video-youtube], [data-video-drive]").forEach((caixa) => {
  const boto = caixa.querySelector(".video__portada");
  if (!boto) return;
  boto.addEventListener("click", () => {
    const yt = caixa.dataset.videoYoutube;
    const drive = caixa.dataset.videoDrive;
    const iframe = document.createElement("iframe");
    iframe.src = yt
      ? `https://www.youtube-nocookie.com/embed/${yt}?autoplay=1&rel=0`
      : `https://drive.google.com/file/d/${drive}/preview`;
    iframe.allow = "autoplay; encrypted-media; picture-in-picture; fullscreen";
    iframe.allowFullscreen = true;
    iframe.title = boto.getAttribute("aria-label") || "Vídeo de les KT Fotos";
    caixa.innerHTML = "";
    caixa.appendChild(iframe);
  });
});

// 7. Notícies: en clicar una targeta, s'obre en gran amb la imatge i el text complet
const lector = document.querySelector(".lector");
const noticies = document.querySelectorAll(".noticies .targeta");
if (lector && noticies.length) {
  const portada = lector.querySelector(".lector__portada");
  const meta = lector.querySelector(".lector__meta");
  const titol = lector.querySelector("#lector-titol");
  const text = lector.querySelector(".lector__text");

  function obreNoticia(targeta, actualitzaAdreca = true) {
    const img = targeta.querySelector("img.targeta__imatge");
    portada.innerHTML = "";
    portada.className = "lector__portada";
    if (img) {
      const gran = document.createElement("img");
      gran.src = targeta.dataset.imatgeGran || img.src;
      gran.alt = img.alt;
      portada.appendChild(gran);
    } else {
      portada.classList.add("lector__portada--color");
      portada.style.background = targeta.dataset.color || "var(--mari)";
      portada.textContent = targeta.dataset.emoji || "";
    }
    if (img) portada.style.background = "";

    meta.innerHTML = "";
    const xip = targeta.querySelector(".xip");
    const data = targeta.querySelector(".targeta__data");
    if (xip) meta.appendChild(xip.cloneNode(true));
    if (data) meta.appendChild(data.cloneNode(true));

    titol.textContent = targeta.querySelector("h3").textContent;
    const complet = targeta.querySelector(".noticia-completa");
    text.innerHTML = complet ? complet.innerHTML : targeta.querySelector(".targeta__cos p").outerHTML;

    lector.showModal();
    lector.scrollTop = 0;
    document.body.classList.add("lector-obert");
    if (actualitzaAdreca && targeta.id) history.replaceState(null, "", "#" + targeta.id);
  }

  noticies.forEach((targeta) => {
    targeta.addEventListener("click", (e) => {
      if (e.target.closest("a")) return; // els enllaços de la targeta funcionen com sempre
      obreNoticia(targeta);
    });
  });

  lector.querySelector(".lector__tanca").addEventListener("click", () => lector.close());
  // Clicar fora de la finestra (al fons fosc) també la tanca
  lector.addEventListener("click", (e) => { if (e.target === lector) lector.close(); });
  lector.addEventListener("close", () => {
    document.body.classList.remove("lector-obert");
    history.replaceState(null, "", location.pathname + location.search);
  });

  // Si s'arriba amb un enllaç tipus noticies.html#kt-fotos (des de la portada), s'obre directament
  const desdeAdreca = location.hash && document.getElementById(location.hash.slice(1));
  if (desdeAdreca && desdeAdreca.matches(".noticies .targeta")) obreNoticia(desdeAdreca, false);
}
