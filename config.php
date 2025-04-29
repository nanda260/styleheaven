<?php 
$host = getenv("mysql.railway.internal");
$user = 'root';
$pass = 'WNbouPbYKZthxuktxYDLUZQUvmfbZMyy';
$dbname = 'railway';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>
