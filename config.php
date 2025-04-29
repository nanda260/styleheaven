<?php 
$host = getenv("mysql.railway.internal");
$user = getenv("root");
$pass = getenv("WNbouPbYKZthxuktxYDLUZQUvmfbZMyy");
$dbname = getenv("railway");

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>
