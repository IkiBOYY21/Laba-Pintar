
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_labapintar";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die("Gagal terhubung ke database: " . mysqli_connect_error());
}

// PASTIKAN BASE_URL SESUAI DENGAN LOKASI PROYEK ANDA
define("BASE_URL", "http://localhost/labapintar/"); 
?>