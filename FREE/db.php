<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "free_db";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Sunucu bağlantı hatası: " . $conn->connect_error);
}

$result = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($result->num_rows == 0) {
    $conn->query("CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci");
}
$conn->select_db($dbname);
$conn->set_charset("utf8");

$sql = "CREATE TABLE IF NOT EXISTS kodlar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(50) NOT NULL,
    baslik VARCHAR(255) NOT NULL,
    icerik TEXT,
    dosya_adi VARCHAR(255),
    tur ENUM('kod','zip') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$conn->query($sql);
?>
