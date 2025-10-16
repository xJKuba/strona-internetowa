<?php
// Przykładowa konfiguracja połączenia z bazą danych
// Skopiuj ten plik jako "config.php" i wpisz swoje dane

$host = 'localhost';
$dbname = 'nazwa_bazy';
$username = 'nazwa_uzytkownika';
$password = 'haslo';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą: " . $e->getMessage());
}
?>