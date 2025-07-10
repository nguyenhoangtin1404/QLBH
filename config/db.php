<?php
$DB_HOST = 'localhost';
$DB_NAME = 'ten_database';    // Thay bằng tên DB thực tế
$DB_USER = 'db_user';
$DB_PASS = '04&DMN4}@*{J';
try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>