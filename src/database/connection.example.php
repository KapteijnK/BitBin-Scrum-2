<?php

// host, gebruikersnaam en wachtwoord van online db invullen
$host = '';
$username = '';
$password = '';
$dbname = 'bitbin';
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
