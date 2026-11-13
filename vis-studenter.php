<?php
include("db-tilkobling.php");

$sqlSetning = "SELECT * FROM oblig1_student ORDER BY brukernavn";
$sqlResultat = mysqli_query($db, $sqlSetning);
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vis alle studenter</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<main class="container">
    <nav><a href="index.php">Til hovedmenyen</a></nav>
    <h1>Vis alle studenter</h1>

    <?php if (!$sqlResultat) { ?>
        <p>Kunne ikke hente studenter fra databasen.</p>
    <?php } elseif (mysqli_num_rows($sqlResultat) == 0) { ?>
        <p>Ingen studenter er registrert.</p>
    <?php } else { ?>
        <table>
            <tr><th>Brukernavn</th><th>Fornavn</th><th>Etternavn</th><th>Klassekode</th></tr>
            <?php
            while ($rad = mysqli_fetch_array($sqlResultat)) {
                $brukernavn = htmlspecialchars($rad["brukernavn"], ENT_QUOTES, "UTF-8");
                $fornavn = htmlspecialchars($rad["fornavn"], ENT_QUOTES, "UTF-8");
                $etternavn = htmlspecialchars($rad["etternavn"], ENT_QUOTES, "UTF-8");
                $klassekode = htmlspecialchars($rad["klassekode"], ENT_QUOTES, "UTF-8");
                print("<tr><td>$brukernavn</td><td>$fornavn</td><td>$etternavn</td><td>$klassekode</td></tr>");
            }
            ?>
        </table>
    <?php } ?>
</main>
</body>
</html>
