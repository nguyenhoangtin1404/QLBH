<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'] ?? '';
    $ngaysinh = $_POST['ngaysinh'] ?? '';
    $doanhthu = $_POST['doanhthu'] ?? 0;
    $gioitinh = $_POST['gioitinh'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $email = $_POST['email'] ?? '';
    $hoatdong = isset($_POST['hoatdong']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO nhanvien (ten, ngaysinh, doanhthu, gioitinh, sdt, email, hoatdong)
        VALUES (:ten, :ngaysinh, :doanhthu, :gioitinh, :sdt, :email, :hoatdong)");
    $stmt->execute([
        ':ten' => $ten,
        ':ngaysinh' => $ngaysinh,
        ':doanhthu' => $doanhthu,
        ':gioitinh' => $gioitinh,
        ':sdt' => $sdt,
        ':email' => $email,
        ':hoatdong' => $hoatdong
    ]);

    header('Location: list.php');
    exit;
}
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Thêm nhân viên</h2>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="ten" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Ngày sinh</label>
        <input type="date" name="ngaysinh" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Doanh thu</label>
        <input type="number" name="doanhthu" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Giới tính</label>
        <select name="gioitinh" class="form-control">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
            <option value="Khác">Khác</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="sdt" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="hoatdong" value="1" class="form-check-input" checked>
        <label class="form-check-label">Đang hoạt động</label>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button>
    <a href="list.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
