# Web de les Catecolònies Sant Martí · Arenys de Munt

Proposta de nova web per substituir el blog [catecolonies.blogspot.com](https://catecolonies.blogspot.com/).
És una web estàtica (només HTML, CSS i una mica de JavaScript): no cal instal·lar res ni cap base de dades.

## Com obrir-la amb Visual Studio Code

1. Descomprimeix la carpeta `web-catecolonies`.
2. A VS Code: **File → Open Folder…** i tria la carpeta `web-catecolonies`.
3. Instal·la l'extensió **Live Server** (de Ritwick Dey) des de la pestanya d'extensions.
4. Clica amb el botó dret sobre `index.html` → **Open with Live Server**.
   La web s'obrirà al navegador i s'actualitzarà sola cada cop que desis un canvi.

(També funciona fent doble clic a `index.html`, però amb Live Server és més còmode.)

## Estructura

```
web-catecolonies/
├── index.html          → Inici (portada, torns, notícies, calendari)
├── qui-som.html        → Missió, valors i història (1984 → avui)
├── inscripcions.html   → Procés, preus, pagament i documentació
├── noticies.html       → Notícies del 2026 (les antigues, al blog)
├── faq.html            → Preguntes freqüents amb cercador i filtres
├── documents.html      → Fitxa, normativa i dossiers 2009–2026
├── css/estil.css       → Tots els estils
├── js/main.js          → Menú mòbil, torns parells/senars i cercador FAQ
├── img/                → Posa-hi les fotos
└── docs/               → Posa-hi els PDF (dossiers, normativa…)
```

## Coses fàcils de canviar

- **Colors:** al principi de `css/estil.css`, a la secció `:root` (per exemple `--verd`, `--groc`, `--coral`).
- **Edats dels torns:** a `js/main.js`, a l'objecte `edatsTorns`.
- **Capçalera i peu de pàgina:** es repeteixen a cada `.html`. Si canvies el menú, canvia'l a totes les pàgines (a VS Code pots fer-ho alhora amb *Edit → Replace in Files*, `Ctrl+Shift+H`).
- **Afegir una notícia:** a `noticies.html`, copia un bloc `<article class="targeta">…</article>` i enganxa'l a dalt de tot.

## Imatges

Ara mateix les fotos s'agafen directament del blog (Blogger). Abans de publicar la web,
és millor descarregar-les a la carpeta `img/` i canviar les rutes, per exemple:
`<img src="img/sortida-2026.jpg" …>`.

## Publicar-la (gratis)

- **GitHub Pages**: puja la carpeta a un repositori i activa Pages.
- **Netlify** o **Vercel**: arrossega la carpeta a la seva web i et donen un enllaç.
- Més endavant es pot connectar un domini propi (per exemple `catecolonies.cat`).

## Pendent de revisar

- Les dates i preus són els del 2026: cal actualitzar-los per al 2027.
- Alguns enllaços de dossiers antics (2009–2019) apunten a Google Sites clàssic i poden no funcionar.
- Falta l'enllaç directe a l'autorització de medicació i al formulari de reserva de les KT Fotos.
- Afegir els logos de l'Ajuntament i de la Fundació Esplais Girona al peu de pàgina.
- Els trets d'Arenys de Munt (franja vermella i blanca, secció «Arrelats a Arenys de Munt», serralada del peu) estan a la secció 20 del CSS: es poden canviar o treure fàcilment.
