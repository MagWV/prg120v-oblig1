<?php
include("db-tilkobling.php");
$melding = "";

if (isset($_POST["registrerKnapp"])) {
    $brukernavn = trim($_POST["brukernavn"] ?? "");
    $fornavn = trim($_POST["fornavn"] ?? "");
    $etternavn = trim($_POST["etternavn"] ?? "");
    $klassekode = trim($_POST["klassekode"] ?? "");

    if ($brukernavn == "" || $fornavn == "" || $etternavn == "" || $klassekode == "") {
        $melding = "Alle feltene må fylles ut.";
    } elseif (strlen($brukernavn) > 7) {
        $melding = "Brukernavnet kan ikke være lengre enn 7 tegn.";
    } else {
        $brukernavnSQL = mysqli_real_escape_string($db, $brukernavn);
        $fornavnSQL = mysqli_real_escape_string($db, $fornavn);
        $etternavnSQL = mysqli_real_escape_string($db, $etternavn);
        $klassekodeSQL = mysqli_real_escape_string($db, $klassekode);

        // Sjekk om brukernavnet finnes fra før.
        $sqlSetning = "SELECT * FROM oblig1_student WHERE brukernavn='$brukernavnSQL'";
        $sqlResultat = mysqli_query($db, $sqlSetning);

        if (!$sqlResultat) {
            $melding = "Kunne ikke kontrollere brukernavnet.";
        } elseif (mysqli_num_rows($sqlResultat) > 0) {
            $melding = "Brukernavnet finnes allerede.";
        } else {
            // Kontroller at klassen finnes.
            $sqlSetning = "SELECT * FROM oblig1_klasse WHERE klassekode='$klassekodeSQL'";
            $sqlResultat = mysqli_query($db, $sqlSetning);

            if (!$sqlResultat) {
                $melding = "Kunne ikke kontrollere klassen.";
            } elseif (mysqli_num_rows($sqlResultat) == 0) {
                $melding = "Klassen finnes ikke.";
            } else {
                $sqlSetning = "INSERT INTO oblig1_student
                               (brukernavn, fornavn, etternavn, klassekode)
                               VALUES ('$brukernavnSQL', '$fornavnSQL', '$etternavnSQL', '$klassekodeSQL')";

                if (mysqli_query($db, $sqlSetning)) {
                    $melding = "Studenten er registrert.";
                } elseif (mysqli_errno($db) == 1062) {
                    $melding = "Brukernavnet finnes allerede.";
                } elseif (mysqli_errno($db) == 1452) {
                    $melding = "Klassen finnes ikke.";
                } else {
                    $melding = "Kunne ikke registrere studenten.";
                }
            }
        }
    }
}

// Klassene hentes fra databasen slik at listeboksen alltid er oppdatert.
$sqlSetning = "SELECT * FROM oblig1_klasse ORDER BY klassekode";
$sqlResultat = mysqli_query($db, $sqlSetning);
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrer student</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<main class="container">
    <nav><a href="index.php">Til hovedmenyen</a></nav>
    <h1>Registrer student</h1>

    <?php if ($melding != "") { ?>
        <p class="melding"><?php print(htmlspecialchars($melding, ENT_QUOTES, "UTF-8")); ?></p>
    <?php } ?>

    <form method="post" action="">
        <label for="brukernavn">Brukernavn</label>
        <input type="text" id="brukernavn" name="brukernavn" maxlength="7" required>

        <label for="fornavn">Fornavn</label>
        <input type="text" id="fornavn" name="fornavn" maxlength="50" required>

        <label for="etternavn">Etternavn</label>
        <input type="text" id="etternavn" name="etternavn" maxlength="50" required>

        <label for="klassekode">Velg klasse</label>
        <select id="klassekode" name="klassekode" required>
            <option value="">Velg klasse</option>
            <?php
            if ($sqlResultat) {
                while ($rad = mysqli_fetch_array($sqlResultat)) {
                    $kode = htmlspecialchars($rad["klassekode"], ENT_QUOTES, "UTF-8");
                    $navn = htmlspecialchars($rad["klassenavn"], ENT_QUOTES, "UTF-8");
                    print("<option value='$kode'>$kode - $navn</option>");
                }
            }
            ?>
        </select>
        <button type="submit" name="registrerKnapp">Registrer student</button>
    </form>
</main>
</body>
</html>
