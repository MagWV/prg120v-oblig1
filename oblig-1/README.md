# PRG120V – Obligatorisk oppgave 1 (enkel PHP-versjon)

Denne versjonen bruker PHP-kode som ligner undervisningseksemplene: `include`, `if/else`, `mysqli_query`, `mysqli_num_rows`, `mysqli_fetch_array`, `SELECT`, `INSERT INTO`, `DELETE FROM` og vanlige HTML-skjemaer. Ingen `match`, egne PHP-hjelpefunksjoner eller `prepare()`.

## Filene

- `index.php`: Hovedmeny med seks lenker.
- `db-tilkobling.php`: Kobler til MySQL med miljøvariabler fra Dokploy.
- `registrer-klasse.php`: Registrerer klasse, kontrollerer om klassekoden finnes.
- `registrer-student.php`: Registrerer student, kontrollerer brukernavn, dynamisk klassevalg.
- `vis-klasser.php` og `vis-studenter.php`: Viser alle rader med `mysqli_fetch_array()`.
- `slett-student.php`: Dynamisk studentliste og bekreftelsesvindu.
- `slett-klasse.php`: Dynamisk klasseliste og bekreftelsesvindu; klasser med studenter kan ikke slettes.
- `stil.css`: Enkel styling.
- `opprett-tabeller.sql`, `testdata-valgfritt.sql`: SQL-kode til dokumentasjon (ikke kjør på nytt i databasen din!).

## Databasen din

Databasen heter `mavat4538`. Du har allerede opprettet `oblig1_klasse` og `oblig1_student` og registrert tre klasser og tre studenter. **Ikke kjør SQL-filene på nytt** – da vil du få feil fordi tabellene/dataene finnes.

`db-tilkobling.php` krever at disse miljøvariablene er satt i Dokploy: `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_DATABASE` (den siste skal være `mavat4538`). Ikke skriv databasepassordet i kode/GitHub.

## Slik publiserer du

1. Pakk ut ZIP-filen og erstatt hele `oblig1`-mappen i ditt lokale `prg120v`-prosjekt. Ta kopi hvis du har gjort egne endringer.
2. Commit og Push origin i GitHub Desktop.
3. Åpne nettsiden (dersom samme URL-oppsett gjelder): `https://dokploy.usn.no/app/mavat4538-Server/oblig1/index.php`.
4. Test alle seks funksjonene. Test en ny klasse og ny student; prøv å registrere samme kode/brukernavn igjen; vis listene; prøv sletting med avbryt og bekreft; sjekk at klasser med studenter ikke kan slettes.

## Hvordan løser vi sikkerhet uten avansert PHP?

- `mysqli_real_escape_string()` brukes før tekst settes inn i SQL. Dette er viktig for å unngå at brukerinput tolkes som SQL. Her bruker vi det bare for å holde koden lik undervisningseksemplene; i større løsninger er *prepared statements* ofte bedre.
- `htmlspecialchars()` brukes når tekst fra databasen vises i HTML.
- `mysqli_report(MYSQLI_REPORT_OFF)` gjør at vi kan håndtere feilmeldinger med vanlige `if`-setninger og `mysqli_errno()`.
- Fremmednøkkelen i databasen hindrer sletting av en klasse som har studenter, også dersom to brukere gjør endringer samtidig.

**Merk:** Selve oppgaveteksten bruker tabellnavnene `klasse` og `student`. Denne versjonen bruker `oblig1_klasse` og `oblig1_student`, fordi du allerede har en annen `student`-tabell i samme database. Avklar at dette er godkjent av faglærer. 

Innlevering i Canvas: lenken til nettsiden. Frist ifølge oppgaven: 16. november 2026.
