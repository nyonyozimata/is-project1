
<?php
// Database connection settings
$host = "localhost";
$dbname = "CAT2";

// Credentials will be configured securely on the VPS.
$dbuser = getenv("CAT2_DB_USER");
$dbpass = getenv("CAT2_DB_PASSWORD");

if (!$dbuser || !$dbpass) {
    die("Database configuration is missing.");
}

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");
?>
