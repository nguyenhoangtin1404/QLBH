<?php
require_once __DIR__ . '/../config/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM nhanvien WHERE id = :id");
$stmt->execute([':id' => $id]);
$nhanvien = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$nhanvien) {
    echo "Không tìm thấy nhân viên.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = $_POST['ten'] ?? '';
    $ngaysinh = $_POST['ngaysinh'] ?? '';
    $doanhthu = $_POST['doanhthu'] ?? 0;
    $gioitinh = $_POST['gioitinh'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $email = $_POST['email'] ?? '';
    $hoatdong = isset($_POST['hoatdong']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE nhanvien SET ten = :ten, ngaysinh = :ngaysinh, doanhthu = :doanhthu,
        gioitinh = :gioitinh, sdt = :sdt, email = :email, hoatdong = :hoatdong WHERE id = :id");
    $stmt->execute([
        ':ten' => $ten,
        ':ngaysinh' => $ngaysinh,
        ':doanhthu' => $doanhthu,
        ':gioitinh' => $gioitinh,
        ':sdt' => $sdt,
        ':email' => $email,
        ':hoatdong' => $hoatdong,
        ':id' => $id
    ]);

    header('Location: list.php');
    exit;
}
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Chỉnh sửa nhân viên</h2>
<form method="POST">
    <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="ten" class="form-control" value="<?= htmlspecialchars($nhanvien['ten']) ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Ngày sinh</label>
        <input type="date" name="ngaysinh" class="form-control" value="<?= htmlspecialchars($nhanvien['ngaysinh']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Doanh thu</label>
        <input type="number" name="doanhthu" class="form-control" value="<?= $nhanvien['doanhthu'] ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Giới tính</label>
        <select name="gioitinh" class="form-control">
            <option value="Nam" <?= $nhanvien['gioitinh'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
            <option value="Nữ" <?= $nhanvien['gioitinh'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
            <option value="Khác" <?= $nhanvien['gioitinh'] == 'Khác' ? 'selected' : '' ?>>Khác</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Số điện thoại</label>
        <input type="text" name="sdt" class="form-control" value="<?= htmlspecialchars($nhanvien['sdt']) ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($nhanvien['email']) ?>">
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="hoatdong" value="1" class="form-check-input" <?= $nhanvien['hoatdong'] ? 'checked' : '' ?>>
        <label class="form-check-label">Đang hoạt động</label>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="list.php" class="btn btn-secondary">Quay lại</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>