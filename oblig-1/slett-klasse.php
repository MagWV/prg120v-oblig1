<?php
include("db-tilkobling.php");
$melding = "";

if (isset($_POST["slettKnapp"])) {
    $klassekode = trim($_POST["klassekode"] ?? "");

    if ($klassekode == "") {
        $melding = "Du må velge en klasse.";
    } else {
        $klassekodeSQL = mysqli_real_escape_string($db, $klassekode);

        // Ikke slett klasser som har studenter.
        $sqlSetning = "SELECT * FROM oblig1_student WHERE klassekode='$klassekodeSQL'";
        $sqlResultat = mysqli_query($db, $sqlSetning);

        if (!$sqlResultat) {
            $melding = "Kunne ikke kontrollere studentene i klassen.";
        } elseif (mysqli_num_rows($sqlResultat) > 0) {
            $melding = "Klassen kan ikke slettes fordi den har studenter.";
        } else {
            $sqlSetning = "DELETE FROM oblig1_klasse WHERE klassekode='$klassekodeSQL'";

            if (mysqli_query($db, $sqlSetning)) {
                if (mysqli_affected_rows($db) > 0) {
                    $melding = "Klassen er slettet.";
                } else {
                    $melding = "Klassen finnes ikke lenger.";
                }
            } elseif (mysqli_errno($db) == 1451) {
                // Databasens fremmednøkkel gir også beskyttelse mot sletting.
                $melding = "Klassen kan ikke slettes fordi den har studenter.";
            } else {
                $melding = "Kunne ikke slette klassen.";
            }
        }
    }
}

// Lag listeboks med klassene som finnes nå.
$sqlSetning = "SELECT * FROM oblig1_klasse ORDER BY klassekode";
$sqlResultat = mysqli_query($db, $sqlSetning);
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slett klasse</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<main class="container">
    <nav><a href="index.php">Til hovedmenyen</a></nav>
    <h1>Slett klasse</h1>
    <p>Klasser som har studenter, kan ikke slettes.</p>

    <?php if ($melding != "") { ?>
        <p class="melding"><?php print(htmlspecialchars($melding, ENT_QUOTES, "UTF-8")); ?></p>
    <?php } ?>

    <form method="post" action="" onsubmit="return confirm('Er du sikker på at du vil slette denne klassen?');">
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
        <button class="danger" type="submit" name="slettKnapp">Slett klasse</button>
    </form>
</main>
</body>
</html>
