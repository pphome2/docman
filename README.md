# DocMan

## Dokimentumkezelő weboldalakhoz

Fejlesztő: [pphome2](https:/github.com/pphome2)

**Aktuális verzió: 2020.**
**Első megjelenés: 2018.**

A programmal dokumentumokat lehet feltölteni a weboldal mellé, ezek megjeleníthető, letölthetők.


Egyszerű:
- nem szükséges CMS a működéshez
- nincs külön felhasználókezelés, két felasználó jelszót tárol a `config` fájlban
- nem kell telepíteni
- nem használ SQL adatbázist
- használhat cookie-kat

### Telepítés

- felmásolni az összes fájlt a webserver megfelelő könyvtárába
- `config` könyvtár `config.php` fájlátnézése, a beállítások itt taláhatók
- írási jog kell a `config.php` fájlban megadott dokumentum tároló könyvtárra
- `config` könyvtárban találhatók a nyelvi fájlok, ha szükséges a módosítható


### Működés

Az adatok a `config.php` könyvtárban megadott dokumentum könyvtárban tárolódnak,
külön alkönyvtárakban. Ezeket szekcióknak nevezzük.

Indítás:
- felhasználó: `index.html`
- adminisztráció: `admin.html`

