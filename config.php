<?php
$host = "localhost";
$username = "root";
$password = "piko12";
$database = "test";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Nie można się połączyć z bazą danych: " . $e->getMessage());
}
?>
