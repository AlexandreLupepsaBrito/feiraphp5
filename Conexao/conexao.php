<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feiragreen";//nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>