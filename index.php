<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';
?>
<h1>Dashboard</h1>
<p>Chào mừng bạn đến với hệ thống Quản lý Bán hàng.</p>
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Tổng Nhân viên</h5>
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) AS count_nv FROM nhanvien");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<p class="card-text">' . $row['count_nv'] . '</p>';
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Tổng Sản phẩm</h5>
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) AS count_sp FROM sanpham");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<p class="card-text">' . $row['count_sp'] . '</p>';
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Tổng Khách hàng</h5>
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) AS count_kh FROM khachhang");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<p class="card-text">' . $row['count_kh'] . '</p>';
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Tổng Đơn hàng</h5>
                <?php
                $stmt = $pdo->query("SELECT COUNT(*) AS count_dh FROM donhang");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<p class="card-text">' . $row['count_dh'] . '</p>';
                ?>
            </div>