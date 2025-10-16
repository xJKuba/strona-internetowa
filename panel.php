<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// dodawanie danych
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $stmt = $pdo->prepare("INSERT INTO dane (imie, nazwisko, wiek, telefon, adres) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['imie'], $_POST['nazwisko'], $_POST['wiek'], $_POST['telefon'], $_POST['adres']]);
}

// usuwanie danych
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM dane WHERE id=?");
    $stmt->execute([$_GET['delete']]);
}

$dane = $pdo->query("SELECT * FROM dane")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Panel</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Panel użytkownika</h2>
<p>Zalogowano jako: <b><?= htmlspecialchars($_SESSION['user']) ?></b></p>
<p>Twój adres IP: <?= $ip ?></p>
<p>Przeglądarka: <?= htmlspecialchars($userAgent) ?></p>

<h3>Dodaj osobę</h3>
<form method="post">
    <input type="text" name="imie" placeholder="Imię" required>
    <input type="text" name="nazwisko" placeholder="Nazwisko" required>
    <input type="number" name="wiek" placeholder="Wiek" required>
    <input type="text" name="telefon" placeholder="Telefon" required>
    <input type="text" name="adres" placeholder="Adres" required>
    <button name="add">Dodaj</button>
</form>

<h3>Lista osób</h3>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Wiek</th><th>Telefon</th><th>Adres</th><th>Usuń</th></tr>
<?php foreach($dane as $row): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['imie']) ?></td>
<td><?= htmlspecialchars($row['nazwisko']) ?></td>
<td><?= $row['wiek'] ?></td>
<td><?= htmlspecialchars($row['telefon']) ?></td>
<td><?= htmlspecialchars($row['adres']) ?></td>
<td><a href="?delete=<?= $row['id'] ?>">❌</a></td>
</tr>
<?php endforeach; ?>
</table>

<br>
<a href="logout.php">Wyloguj</a>
</div>
</body>
</html>