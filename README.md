# Liceul Teoretic ”Petru Maior” -> Site + Portal
See instructions for running locally at the end of this README.

I apologise for this Readme being in Romanian. I didn't know better at the time.

## Ce e asta
Păi, pe scurt, un număr de elevi ai LTPM ne-am adunat într-o echipă și dorim să refacem de la zero site-ul liceului nostru, și de asemenea să creem un catalog electronic, de la zero, pentru a fi folosit de elevi și profesori. Portalul (catalogul electronic) are rolul secundar de a crea un element de unitate între elevii liceului.
## De ce există așa ceva
Poveste lungă... dar pe scurt, ne plictisim. Programatorii trebuie să scrie cod. Și noi chiar scriem!, ajungem la 300 de linii pentru fiecare modal din Portal! Woo!
## „Echipa IT”
* Pricop Laurențiu (XI-A)(coordonator, back-end)
* Iakab Edward (XI-A)(front-end, back-end)
* Stoica Darius (X-A)(designer grafic, front-end)
* Duca Cosmin (XI-A)(Unity și C#)
* Rad Antonio (XI-A)(designer grafic)
* Vlad Grozav (XI-B)(relații sociale, viziunea noastră)

Ne-am bucura de orice fel de ajutor pe partea de programare! Dacă ești un entuziast elev al LTPM care e interesat de programare, ne poți contacta! Singura noastră cerință e să fii confortabil cu stilul de cod practicat de noi, pe care-l poți explora.
## Pot contribui în afara echipei?
Vei putea, dar nu încă. Doresc să pun la punct modul în care se poate contribui, contribute.md și alte chichițe. Dar poți face orice vrei tu cu acest proiect (în limita licenței), îl poți fork-ui, să lași issues, și le vom lua în considerare!
## FUNCȚIONALITĂȚI PLANIFICATE
### Portal LTPM
* [x] (14.02.2020) Implementarea înregistrării prin coduri de acces
* [ ] Implementarea super-logului global (pt administrație)
* [ ] Implementarea unui sistem mai complex de permisiuni (probabil)
* [ ] Implementarea unui sistem pentru adăugarea de Resurse
* [ ] Implementarea sesiunii de utilizator extinse
* [X] (21.04.2020) Diferite tipuri de note (oral, scris, sau TEZĂ)
* [ ] Abilitatea de a fi profesor suplinitor altor clase
  * Probabil depinde de: sistem complex de permisiuni
* [ ] Creearea și întreținerea unor statistici (hits, visits etc.)
* [x] Asigurarea consistenței vizuale și funcționale globale (adică totul să arate și să funcționeze similar)
* [x] Confirmarea parolei pentru accesarea datelor sensibile din baza de date
* [ ] Crearea unui API (Portal API) pentru uz din afară (ar facilita crearea de aplicații de către elevi, sau idk)
* [ ] Sistem pentru a raporta probleme și bugs
#### Securitate
* [ ] Securizare sesiuni si form IDs asa cum e mentionat [aici](https://www.moesif.com/blog/technical/restful-apis/Authorization-on-RESTful-APIs/#cookies)
#### TODO Minore
* [x] (16.04.2020) Filtrare in portal/admin:clase
### Site principal

## Getting this running on your machine (2024 addition)
I have created a `docker-compose.yml` file to allow easy local testing of this thing.

Before getting the containers up, create a file at `portal/include/dbconfig.php` with the following content:
```php
<?php

return [
  'hostname' => 'mysql',
  'username' => 'bubu',
  'password' => 'bubu',
  'database' => 'ltpmdb'
];
```

Now get the infra up with `docker compose up`.

There is a database export in the project, but it's not quite up to date. I've fixed the db as much as I cared to, so that most features work (except stuff in Resurse idk), and I left you an export in `portal/include/dbschema-2024.sql`. Connect to Adminer on `localhost:8080` and import the SQL there.

You can now open `localhost:8000` in your browser. In the Portal, use `laur` and `1234` to login with an administrator account. There's some trash data already in.

Have fun!