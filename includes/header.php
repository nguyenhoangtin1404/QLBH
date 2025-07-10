<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý bán hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">Quản lý Bán hàng</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/nhanvien/list.php">Nhân viên</a></li>
                <li class="nav-item"><a class="nav-link" href="/sanpham/list.php">Sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="/khachhang/list.php">Khách hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="/donhang/list.php">Đơn hàng</a></li>
                <li class="nav-item"><a class="nav-link" href="/magiamgia/list.php">Mã giảm giá</a></li>
                <li class="nav-item"><a class="nav-link" href="/lichsutichdiem/list.php">Lịch sử tích điểm</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
