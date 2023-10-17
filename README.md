# SpletnaTrgovina

## Vloge uporabnikov

V seminarski nalogi izdelajte model spletne prodajalne z uporabo tehnologij Linux, Apache, SUPB MySQL, PHP, SSL ter certifikatov X.509. Spletna prodajalna naj ima naslednje uporabnike, pri katerih hranite spodaj navedene atribute.

- **Administrator**: Ime, Priimek, Elektronski naslov in geslo.
- **Prodajalec**: Ime, Priimek, Elektronski naslov in geslo.
- **Stranka**: Ime, Priimek, Naslov (sestavljen iz ulice, hišne številke, pošte in poštne številke), Elektronski naslov, geslo.
- **Anonimni odjemalec**, pri katerem ne hranite atributov.

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

### Spletni vmesnik vloge Stranka

Vmesnik naj omogoča:

- Prijavo in odjavo;
- Posodobitev lastnega gesla in ostalih atributov;
- Nakupovanje. To naj bo sestavljeno iz:
  - Pregledovanja artiklov trgovine;
  - Dodajanja in odstranjevanja artiklov v košarico ter spreminjanja količine v košarici;
  - Zaključka nakupa. Tu se naj stranki prikaže povzetek kupljenih izdelkov s predračunom. Ko stranka naročilo potrdi, se to doda v čakalno vrsto neobdelanih naročil, kjer ga lahko v obravnavo prevzame Prodajalec.
- Dostop do seznama preteklih nakupov. Uporabnik lahko vidi vsa svoja pretekla naročila: oddana, potrjena, preklicana in stornirana.
- Uporaba vmesnika Stranka je dovoljena le preko zavarovanega kanala. Odjemalca overite z uporabniškim imenom in geslom, ki naj bosta shranjena v SUPB.

### Spletni vmesnik vloge anonimnega odjemalca

Vmesnik naj omogoča:

- Pregledovanje artiklov preko spletnega vmesnika;
- Registracijo preko spletnega vmesnika;
- Uporaba vmesnika anonimnega odjemalca je preko javnega in zavarovanega kanala, pri registraciji pa nujno preklopite na zavarovan kanal. V splošnem poskrbite za ustrezno preklapljanje med omenjenima kanaloma.

### Ostale zahteve

Vaša rešitev naj zadosti še omenjenim zahtevam:

- Vzpostavite lastno certifikatno agencijo in z njo izdelajte strežniško digitalno potrdilo. Digitalno potrdilo namestite v strežnik Apache.
- Osebne certifikate izdelajte ročno z namenskim programom in z uporabo iste certifikatne agencije, kot ste jo uporabili za izdelavo strežniškega certifikata. Uporabite smiselna polja certifikata ter na ustrezen način povežite identiteto uporabnika v bazi z identiteto zapisano v certifikatu.
- Pri realizaciji vseh delov prodajalne skrbno preverjajte vnose s strani odjemalca, pri čemer bodite posebej pozorni na napade injekcije kode SQL ter napade XSS.
- Metode protokola HTTP realizirajte v skladu s priporočili standarda HTTP, kjer uporabite zahtevke z metodo GET za lahke operacije, za zahtevnejše pa zahtevke z metodo POST.
- Poskrbite za ustrezno hrambo gesel.
- Izdelan model podatkovne baze naj bo normaliziran do tretje normalne oblike. Vse denormalizacije morajo biti utemeljene.

