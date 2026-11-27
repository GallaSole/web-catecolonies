"""Extreu el contingut de la web estàtica de les KT a un JSON que el tema de WordPress
importa quan s'activa (inc/dades-inicials.json)."""
import json
import re
import sys
from pathlib import Path

from bs4 import BeautifulSoup, NavigableString, Tag

WEB = Path(sys.argv[1])
SORTIDA = Path(sys.argv[2])

MESOS = {
    "gener": 1, "febrer": 2, "març": 3, "abril": 4, "maig": 5, "juny": 6, "juliol": 7,
    "agost": 8, "setembre": 9, "octubre": 10, "novembre": 11, "desembre": 12,
}


def sopa(nom):
    return BeautifulSoup((WEB / nom).read_text(encoding="utf-8"), "lxml")


def data_iso(text):
    m = re.match(r"(\d+) d(?:e |')(\w+) de (\d{4})", text.strip())
    dia, mes, any_ = m.groups()
    return f"{any_}-{MESOS[mes]:02d}-{int(dia):02d} 10:00:00"


def enllacos_interns(html):
    """index.html -> {{web}}/ ; faq.html -> {{web}}/faq/ ; noticies.html#x -> {{web}}/noticies/#x"""
    def canvia(m):
        nom, hash_ = m.group(1), m.group(2) or ""
        if nom == "index":
            return 'href="{{web}}/' + hash_ + '"'
        return 'href="{{web}}/' + nom + "/" + hash_ + '"'
    return re.sub(r'href="([a-z0-9-]+)\.html(#[^"]*)?"', canvia, html)


def interior(tag):
    return enllacos_interns("".join(str(c) for c in tag.contents)).strip()


def blocs(contenidor):
    """Converteix els fills d'un element en blocs de l'editor de WordPress."""
    sortida = []
    for fill in contenidor.children:
        if isinstance(fill, NavigableString):
            if fill.strip():
                sortida.append(f"<!-- wp:paragraph -->\n<p>{fill.strip()}</p>\n<!-- /wp:paragraph -->")
            continue
        if not isinstance(fill, Tag):
            continue
        if fill.name == "p":
            classes = " ".join(fill.get("class", []))
            if classes:
                attrs = json.dumps({"className": classes}, ensure_ascii=False)
                sortida.append(f'<!-- wp:paragraph {attrs} -->\n<p class="{classes}">{interior(fill)}</p>\n<!-- /wp:paragraph -->')
            else:
                sortida.append(f"<!-- wp:paragraph -->\n<p>{interior(fill)}</p>\n<!-- /wp:paragraph -->")
        elif fill.name in ("h2", "h3", "h4") and not fill.get("class"):
            nivell = int(fill.name[1])
            attrs = "" if nivell == 2 else " " + json.dumps({"level": nivell})
            sortida.append(f'<!-- wp:heading{attrs} -->\n<{fill.name} class="wp-block-heading">{interior(fill)}</{fill.name}>\n<!-- /wp:heading -->')
        elif fill.name in ("ul", "ol") and not fill.get("class"):
            items = "".join(f"<!-- wp:list-item -->\n<li>{interior(li)}</li>\n<!-- /wp:list-item -->\n" for li in fill.find_all("li", recursive=False))
            attrs = ' {"ordered":true}' if fill.name == "ol" else ""
            sortida.append(f'<!-- wp:list{attrs} -->\n<{fill.name} class="wp-block-list">{items}</{fill.name}>\n<!-- /wp:list -->')
        else:
            sortida.append(f"<!-- wp:html -->\n{enllacos_interns(str(fill))}\n<!-- /wp:html -->")
    return "\n\n".join(sortida)


def text(tag):
    return " ".join(tag.get_text(" ", strip=True).split())


dades = {}

# ---------- Notícies ----------
noticies = []
s = sopa("noticies.html")
for art in s.select(".noticies article.targeta"):
    img = art.select_one("img.targeta__imatge")
    boto = art.select_one(".targeta__llegeix")
    xip = art.select_one(".xip")
    complet = art.select_one(".noticia-completa")
    noticies.append({
        "slug": art["id"],
        "titol": text(art.select_one("h3")),
        "categoria": text(xip) if xip else "",
        "data": data_iso(text(art.select_one(".targeta__data"))),
        "resum": interior(art.select_one(".targeta__cos > p")),
        "text_boto": text(boto) if boto else "",
        "imatge": img["src"] if img else "",
        "imatge_gran": art.get("data-imatge-gran", ""),
        "imatge_alt": img.get("alt", "") if img else "",
        "imatge_logo": bool(img and "targeta__imatge--logo" in img.get("class", [])),
        "contingut": blocs(complet) if complet else "",
    })
dades["noticies"] = noticies

# ---------- FAQ ----------
s = sopa("faq.html")
temes = [{"slug": b["data-cat"], "nom": text(b)} for b in s.select(".faq-filtres button") if b["data-cat"] != "totes"]
preguntes = []
for d in s.select(".faq details"):
    resposta = d.find("div", recursive=False)
    preguntes.append({"pregunta": text(d.summary), "tema": d["data-cat"], "resposta": blocs(resposta)})
dades["faq"] = {"temes": temes, "preguntes": preguntes}

# ---------- Documents ----------
s = sopa("documents.html")
utils = []
for a in s.select(".graella-3 a.caixa"):
    titol = text(a.h3)
    icona, _, nom = titol.partition(" ")
    utils.append({"titol": nom, "icona": icona, "enllac": a["href"], "descripcio": text(a.p)})
dossiers = []
for a in s.select(".docs a.doc"):
    nom = text(a.span).replace(" · el més recent", "")
    dossiers.append({"titol": nom, "any": text(a.b), "enllac": a["href"]})
dades["documents"] = {"utils": utils, "dossiers": dossiers}

# ---------- KT Fotos ----------
s = sopa("kt-fotos.html")
videos = []
gran = s.select_one(".video--gran")
videos.append({"any": text(gran.select_one(".video__any-gran")), "enllac": "https://drive.google.com/file/d/" + gran["data-video-drive"] + "/view"})
for art in s.select(".video-targeta"):
    v = art.select_one("[data-video-youtube]")
    videos.append({"any": text(art.select_one(".video-targeta__peu b")), "enllac": "https://youtu.be/" + v["data-video-youtube"]})
dades["videos"] = videos

# ---------- Mini-KT ----------
s = sopa("minikt.html")
mk = s.select_one(".minikt")
camps = {text(d.span): d for d in mk.select(".minikt__dades > div")}
def b_i_small(div):
    sm = div.select_one("small")
    return text(div.b), (text(sm) if sm else "")
trobada, trobada_lloc = b_i_small(camps["Trobada"])
insc, insc_lloc = b_i_small(camps["Inscripcions"])
titol_mk = text(s.select_one(".seccio--blanca h2"))  # "Mini-KT 2n torn · 2026"
m = re.match(r"Mini-KT (.+) · (\d{4})", titol_mk)
llistes = mk.select(".minikt__llistes ul")
minikts = [{
    "titol": "Mini-KT del " + m.group(1),
    "any": m.group(2),
    "torns": m.group(1),
    "resum": "",
    "dates": text(camps["Dates"].b),
    "preu": text(camps["Preu"].b),
    "trobada": trobada,
    "trobada_lloc": trobada_lloc,
    "inscripcions": insc,
    "inscripcions_lloc": insc_lloc,
    "cartell": mk.select_one(".minikt__cartell")["src"],
    "per_inscriure": "\n".join(text(li) for li in llistes[0].select("li")),
    "que_portar": "\n".join(text(li) for li in llistes[1].select("li")),
}]
for f in s.select(".fita-mini"):
    minikts.append({
        "titol": text(f.h3),
        "any": text(f.select_one(".fita-mini__any")),
        "torns": ", ".join(text(x) for x in f.select(".xip")),
        "resum": text(f.p),
    })
dades["minikt"] = minikts

# ---------- Descripcions de cada pàgina (per als cercadors) ----------
descr = {}
for nom in ["index", "qui-som", "inscripcions", "minikt", "kt-fotos", "noticies", "faq", "documents"]:
    meta = sopa(f"{nom}.html").select_one('meta[name="description"]')
    descr[nom] = meta["content"] if meta else ""
dades["descripcions"] = descr

SORTIDA.write_text(json.dumps(dades, ensure_ascii=False, indent=1), encoding="utf-8")
print(len(noticies), "notícies ·", len(preguntes), "preguntes ·", len(utils) + len(dossiers), "documents ·",
      len(videos), "vídeos ·", len(minikts), "mini-KT")
