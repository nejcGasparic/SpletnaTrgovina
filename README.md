# SpletnaTrgovina

## Vloge uporabnikov

V seminarski nalogi izdelajte model spletne prodajalne z uporabo tehnologij Linux, Apache, SUPB MySQL, PHP, SSL ter certifikatov X.509. Spletna prodajalna naj ima naslednje uporabnike, pri katerih hranite spodaj navedene atribute.

- Administrator: Ime, Priimek, Elektronski naslov in geslo.
- Prodajalec: Ime, Priimek, Elektronski naslov in geslo.
- Stranka: Ime, Priimek, Naslov (sestavljen iz ulice, hišne številke, pošte in poštne številke), Elektronski naslov, geslo.
- Anonimni odjemalec, pri katerem ne hranite atributov.

## Osnovne storitve

Osnovne storitve prodajalne naj podpirajo naslednje operacije pri vsaki vlogi.

### Spletni vmesnik vloge Administrator

Vmesnik naj omogoča:

- Prijavo in odjavo. Dostop je dovoljen le odjemalcem, ki se overijo s pomočjo certifikatov X.509;
- Posodobitev lastnega gesla in ostalih atributov;
- Ustvarjanje, aktiviranje in deaktiviranje uporabniškega računa Prodajalec ter posodobitev njegovih atributov. (Deaktivirati nek podatkovni objekt pomeni, da deluje kot da bi bil izbrisan: denimo deaktiviran uporabnik se ne more prijaviti v sistem, vendar se njegovi podatki v sistemu še vedno nahajajo, deaktiviranega artikla ne prikažemo v prodajali in podobno. Takšno deaktivacijo imenujemo tudi "mehki izbris".)
  
V vlogi administratorja imate lahko zgolj enega uporabnika, ki ga lahko kreirate ročno, denimo z uporabo določene skripte, vmesnika phpmyadmin in podobno.

### Spletni vmesnik vloge Prodajalec

Vmesnik naj omogoča:

- Prijavo in odjavo. Dostop je dovoljen le odjemalcem, ki se overijo s pomočjo certifikatov X.509;
- Posodobitev lastnega gesla in ostalih atributov;
- Obdelavo naročil. Slednje obsega:
  - Pregled še neobdelanih naročil in njihovih postavk. Posamezno naročilo se prodajalcu prikaže šele, ko Stranka z nakupom zaključi;
  - Potrjevanje ali preklic oddanih naročil;
  - Ogled zgodovine potrjenih naročil in možnost storniranja potrjenih naročil.
- Ustvarjanje, aktiviranje in deaktiviranje artiklov in posodabljanje njihovih atributov. Pri obravnavi artiklov lahko upravljanje z zalogami izpustite. Z drugimi besedami -- v aplikaciji lahko vedno predpostavite, da je na zalogi dovolj artiklov;
- Ustvarjanje, aktiviranje in deaktiviranje uporabniških računov tipa Stranka in posodabljanje njegovih atributov.
  
Razlaga statusa naročila:

- Neobdelano naročilo je naročilo, ki ga je Stranka oddala.
- Potrjeno naročilo je naročilo, ki ga je Stranka oddala, Prodajalec pa potrdil.
- Preklicano naročilo je naročilo, ki ga je Stranka oddala, Prodajalec pa preklical.
- Stornirano naročilo je naročilo, ki ga je Stranka oddala, Prodajalec potrdil in naknadno storniral tj. stornirati je mogoče le potrjena naročila.
