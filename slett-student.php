<?php
include("db-tilkobling.php");
$melding = "";

if (isset($_POST["slettKnapp"])) {
    $brukernavn = trim($_POST["brukernavn"] ?? "");

    if ($brukernavn == "") {
        $melding = "Du må velge en student.";
    } else {
        $brukernavnSQL = mysqli_real_escape_string($db, $brukernavn);
        $sqlSetning = "DELETE FROM oblig1_student WHERE brukernavn='$brukernavnSQL'";

        if (mysqli_query($db, $sqlSetning)) {
            if (mysqli_affected_rows($db) > 0) {
                $melding = "Studenten er slettet.";
            } else {
                $melding = "Studenten finnes ikke lenger.";
            }
        } else {
            $melding = "Kunne ikke slette studenten.";
        }
    }
}

// Lag listeboks med studentene som finnes nå.
$sqlSetning = "SELECT * FROM oblig1_student ORDER BY brukernavn";
$sqlResultat = mysqli_query($db, $sqlSetning);
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slett student</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<main class="container">
    <nav><a href="index.php">Til hovedmenyen</a></nav>
    <h1>Slett student</h1>

    <?php if ($melding != "") { ?>
        <p class="melding"><?php print(htmlspecialchars($melding, ENT_QUOTES, "UTF-8")); ?></p>
    <?php } ?>

    <form method="post" action="" onsubmit="return confirm('Er du sikker på at du vil slette denne studenten?');">
        <label for="brukernavn">Velg student</label>
        <select id="brukernavn" name="brukernavn" required>
            <option value="">Velg student</option>
            <?php
            if ($sqlResultat) {
                while ($rad = mysqli_fetch_array($sqlResultat)) {
                    $brukernavn = htmlspecialchars($rad["brukernavn"], ENT_QUOTES, "UTF-8");
                    $navn = htmlspecialchars($rad["fornavn"] . " " . $rad["etternavn"], ENT_QUOTES, "UTF-8");
                    print("<option value='$brukernavn'>$brukernavn - $navn</option>");
                }
            }
            ?>
        </select>
        <button class="danger" type="submit" name="slettKnapp">Slett student</button>
    </form>
</main>
</body>
</html>
