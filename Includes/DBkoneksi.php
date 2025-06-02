<?php
$host = 'localhost';
$user = 'root';
$password = ''; 
$database = 'ngajar_id'; 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
} 
?>
