# Tema de WordPress de les Catecolònies

Aquest tema fa que la web de les KT es vegi exactament igual que la web original, però feta amb WordPress perquè qualsevol persona de l'entitat la pugui actualitzar des del navegador.

## Com s'instal·la

1. Al hosting, instal·la WordPress (a Dinahosting es fa des del panell, amb l'instal·lador d'aplicacions). Tria **Català** com a idioma.
2. Entra al tauler de WordPress: **Aparença → Temes → Afegeix → Puja un tema** i tria el fitxer `catecolonies.zip`.
3. Clica **Activa**. La primera vegada, el tema crea sol totes les pàgines, el menú i el contingut actual (notícies, preguntes, documents, vídeos i Mini-KT).
4. Si per algun motiu no s'hagués creat, ves a **Eines → Contingut de les KT** i clica el botó.

## Qui pot editar

A **Usuaris → Afegeix**, crea un usuari per a cada persona que hagi d'editar la web:

- **Editor**: pot publicar i canviar notícies, preguntes, documents, vídeos i Mini-KT. És el que va bé per a la majoria.
- **Administrador**: a més, pot canviar opcions, menús i instal·lar coses. Millor que n'hi hagi només un parell.

## Què es canvia i on

| Què | On |
| --- | --- |
| Notícies (surten soles a Notícies i a la portada) | **Notícies → Afegeix-ne una** |
| Avís de la portada, text i foto de dalt | **Aparença → Personalitza → Les KT → Portada** |
| Dates de les colònies (compte enrere) | **Aparença → Personalitza → Les KT → Dates de les colònies** |
| Preus, IBAN, cartell i fitxes d'inscripció | **Aparença → Personalitza → Les KT → Inscripcions i preus** |
| Avís «Pròximament» de les KT Fotos | **Aparença → Personalitza → Les KT → KT Fotos** |
| Correu, Instagram i blog antic | **Aparença → Personalitza → Les KT → Contacte i xarxes** |
| Preguntes freqüents i els seus filtres | **Preguntes freqüents** (els filtres són els **Temes**) |
| Dossiers i documents | **Documents** |
| Vídeos de les KT Fotos | **Vídeos KT Fotos** |
| Mini-KT | **Mini-KT** |
| Menú de dalt i del peu | **Aparença → Menús** |

Les seccions que no canvien gairebé mai (els torns, les dates destacades de l'any, la història a «Qui som» i la comparativa de les Mini-KT) són dins de les plantilles del tema, a la carpeta del tema.

## Notícies: com queden boniques

- **Títol** i **text** de la notícia, com en qualsevol editor.
- **Imatge destacada** (columna de la dreta): la foto de la targeta. També es pot posar un enllaç d'imatge al camp «Imatge des d'un enllaç», a sota del text.
- **Extracte** (columna de la dreta): el resum curt de la targeta. Si no n'hi poses, es fa sol.
- **Categoria**: l'etiqueta petita que surt a la targeta (per exemple «ràdio» o «sortida»).
- **Data**: la data que surt a la targeta.

## Fitxers del tema

- `assets/css/estil.css`: el disseny de la web (el mateix que la web original).
- `assets/js/main.js`: menú del mòbil, compte enrere, filtres de les preguntes, vídeos i lector de notícies.
- `front-page.php`, `home.php`, `page-*.php`: les plantilles de cada pàgina.
- `inc/`: tipus de contingut, camps, opcions, guia del tauler i importador.
- `inc/dades-inicials.json`: el contingut que s'importa la primera vegada.
