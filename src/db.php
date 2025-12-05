<?php
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Falha DB: " . $conn->connect_error);
}

// Cria tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS wifi_users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mac_address VARCHAR(30) NOT NULL,
    fullname VARCHAR(100),
    email VARCHAR(100),
    method VARCHAR(20), -- 'registro' ou 'token'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);
?>