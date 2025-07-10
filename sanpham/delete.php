<?php
require_once __DIR__ . '/../config/db.php';
$id = isset($_GET['id'])? (int)$_GET['id']:0;
if($id){ $stmt=$pdo->prepare("DELETE FROM sanpham WHERE id=:id"); $stmt->execute([':id'=>$id]); }
header('Location: list.php'); exit;
?>