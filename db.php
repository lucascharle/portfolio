<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio";

$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");

$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS skills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
)");

$result = $conn->query("SELECT COUNT(*) AS total FROM skills");
$row = $result->fetch_assoc();
if ($row['total'] == 0) {
    $conn->query("INSERT INTO skills (name) VALUES 
    ('Sérieux'), ('Motivé'), ('À l\'écoute'), ('Déterminé')");
}
?>