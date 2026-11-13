<?php
/* Kobling til MySQL-databasen på Dokploy */
$host = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$database = getenv("DB_DATABASE");

/* Gjør at mysqli_query() gir false ved feil, i stedet for å stoppe siden. */
mysqli_report(MYSQLI_REPORT_OFF);

$db = mysqli_connect($host, $username, $password, $database);

if (!$db) {
    die("Kunne ikke koble til databasen.");
}

mysqli_set_charset($db, "utf8mb4");
?>
