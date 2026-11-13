<?php
include("db-tilkobling.php");
$melding = "";

if (isset($_POST["registrerKnapp"])) {
    $klassekode = trim($_POST["klassekode"] ?? "");
    $klassenavn = trim($_POST["klassenavn"] ?? "");
    $studiumkode = trim($_POST["studiumkode"] ?? "");

    if ($klassekode == "" || $klassenavn == "" || $studiumkode == "") {
        $melding = "Alle feltene må fylles ut.";
    } elseif (strlen($klassekode) > 5) {
        $melding = "Klassekoden kan ikke være lengre enn 5 tegn.";
    } else {
        // Gjør tekstverdiene trygge å bruke i SQL-setningene.
        $klassekodeSQL = mysqli_real_escape_string($db, $klassekode);
        $klassenavnSQL = mysqli_real_escape_string($db, $klassenavn);
        $studiumkodeSQL = mysqli_real_escape_string($db, $studiumkode);

        // Sjekk om klassekoden finnes fra før.
        $sqlSetning = "SELECT * FROM oblig1_klasse WHERE klassekode='$klassekodeSQL'";
        $sqlResultat = mysqli_query($db, $sqlSetning);

        if (!$sqlResultat) {
            $melding = "Kunne ikke kontrollere klassekoden.";
        } elseif (mysqli_num_rows($sqlResultat) > 0) {
            $melding = "Klassekoden finnes allerede.";
        } else {
            // Registrer klassen.
            $sqlSetning = "INSERT INTO oblig1_klasse (klassekode, klassenavn, studiumkode)
                           VALUES ('$klassekodeSQL', '$klassenavnSQL', '$studiumkodeSQL')";

            if (mysqli_query($db, $sqlSetning)) {
                $melding = "Klassen er registrert.";
            } elseif (mysqli_errno($db) == 1062) {
                $melding = "Klassekoden finnes allerede.";
            } else {
                $melding = "Kunne ikke registrere klassen.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrer klasse</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<main class="container">
    <nav><a href="index.php">Til hovedmenyen</a></nav>
    <h1>Registrer klasse</h1>

    <?php if ($melding != "") { ?>
        <p class="melding"><?php print(htmlspecialchars($melding, ENT_QUOTES, "UTF-8")); ?></p>
    <?php } ?>

    <form method="post" action="">
        <label for="klassekode">Klassekode</label>
        <input type="text" id="klassekode" name="klassekode" maxlength="5" required>

        <label for="klassenavn">Klassenavn</label>
        <input type="text" id="klassenavn" name="klassenavn" maxlength="50" required>

        <label for="studiumkode">Studiumkode</label>
        <input type="text" id="studiumkode" name="studiumkode" maxlength="50" required>

        <button type="submit" name="registrerKnapp">Registrer klasse</button>
    </form>
</main>
</body>
</html>
