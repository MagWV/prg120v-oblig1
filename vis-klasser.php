<?php
include("db-tilkobling.php");

$sqlSetning = "SELECT * FROM oblig1_klasse ORDER BY klassekode";
$sqlResultat = mysqli_query($db, $sqlSetning);
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vis alle klasser</title>
    <link rel="stylesheet" href="stil.css">
</head>
<body>
<main class="container">
    <nav><a href="index.php">Til hovedmenyen</a></nav>
    <h1>Vis alle klasser</h1>

    <?php if (!$sqlResultat) { ?>
        <p>Kunne ikke hente klasser fra databasen.</p>
    <?php } elseif (mysqli_num_rows($sqlResultat) == 0) { ?>
        <p>Ingen klasser er registrert.</p>
    <?php } else { ?>
        <table>
            <tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>
            <?php
            while ($rad = mysqli_fetch_array($sqlResultat)) {
                $klassekode = htmlspecialchars($rad["klassekode"], ENT_QUOTES, "UTF-8");
                $klassenavn = htmlspecialchars($rad["klassenavn"], ENT_QUOTES, "UTF-8");
                $studiumkode = htmlspecialchars($rad["studiumkode"], ENT_QUOTES, "UTF-8");
                print("<tr><td>$klassekode</td><td>$klassenavn</td><td>$studiumkode</td></tr>");
            }
            ?>
        </table>
    <?php } ?>
</main>
</body>
</html>
