<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy đơn hàng
$stmt = $pdo->prepare("SELECT * FROM donhang WHERE id = :id");
$stmt->execute([':id' => $id]);
$dh = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$dh) {
    echo '<div class="alert alert-danger">Không tìm thấy đơn hàng.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Lấy danh sách select options
$kh_list = $pdo->query("SELECT id, ten FROM khachhang ORDER BY ten")->fetchAll(PDO::FETCH_ASSOC);
nv_list = $pdo->query("SELECT id, ten FROM nhanvien ORDER BY ten")->fetchAll(PDO::FETCH_ASSOC);
$mg_list = $pdo->query("SELECT id, ma FROM ma_giam_gia ORDER BY ma")->fetchAll(PDO::FETCH_ASSOC);
$sp_list = $pdo->query("SELECT id, ten, gia_ban FROM sanpham ORDER BY ten")->fetchAll(PDO::FETCH_ASSOC);

// Lấy chi tiết hiện tại
$stmt_ct = $pdo->prepare("SELECT * FROM chi_tiet_donhang WHERE donhang_id = :id");
$stmt_ct->execute([':id' => $id]);
$ctdh_list = $stmt_ct->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xử lý cập nhật thông tin đơn
    $kh_id = $_POST['khachhang_id'];
    $thoigian_dat = $_POST['thoigian_dat'];
    $nv_id = $_POST['nhanvien_id'];
    $mg_id = $_POST['ma_giam_gia_id'] ? $_POST['ma_giam_gia_id'] : null;
    $tong_tien = 0;
    foreach ($_POST['sanpham_id'] as $index => $sp_id) {
        $qty = (int)$_POST['so_luong'][$index];
        $gia = (float)str_replace([',','.'],['',''],$_POST['gia_ban_chon'][$index]);
        $tong_tien += $qty * $gia;
    }
    $tien_thanh_toan = (float)str_replace([',','.'],['',''],$_POST['tien_thanh_toan']);

    // Cập nhật donhang
    $sql = "UPDATE donhang SET khachhang_id = :khachhang_id, thoigian_dat = :thoigian_dat, tong_tien = :tong_tien, tien_thanh_toan = :tien_thanh_toan, nhanvien_id = :nhanvien_id, ma_giam_gia_id = :ma_giam_gia_id WHERE id = :id";
    $stmt2 = $pdo->prepare($sql);
    $stmt2->execute([':khachhang_id'=>$kh_id, ':thoigian_dat'=>$thoigian_dat, ':tong_tien'=>$tong_tien, ':tien_thanh_toan'=>$tien_thanh_toan, ':nhanvien_id'=>$nv_id, ':ma_giam_gia_id'=>$mg_id, ':id'=>$id]);

    // Xóa chi tiết cũ và thêm mới
    $pdo->prepare("DELETE FROM chi_tiet_donhang WHERE donhang_id = :id")->execute([':id' => $id]);
    $stmt_ctins = $pdo->prepare("INSERT INTO chi_tiet_donhang (donhang_id, sanpham_id, so_luong, gia_ban_thuc_te) VALUES (:donhang_id, :sanpham_id, :so_luong, :gia_ban_thuc_te)");
    foreach ($_POST['sanpham_id'] as $index => $sp_id) {
        $qty = (int)$_POST['so_luong'][$index];
        $gia = (float)str_replace([',','.'],['',''],$_POST['gia_ban_chon'][$index]);
        $stmt_ctins->execute([':donhang_id'=>$id, ':sanpham_id'=>$sp_id, ':so_luong'=>$qty, ':gia_ban_thuc_te'=>$gia]);
    }

    header('Location: list.php'); exit;
}
?>
<h2>Chỉnh sửa Đơn hàng #<?php echo $dh['id']; ?></h2>
<form method="post" action="edit.php?id=<?php echo $id; ?>">
    <div class="mb-3">
        <label for="khachhang_id" class="form-label">Khách hàng</label>
        <select name="khachhang_id" id="khachhang_id" class="form-select" required>
            <option value="">-- Chọn khách hàng --</option>
            <?php foreach ($kh_list as $kh): ?>
                <option value="<?php echo $kh['id']; ?>" <?php echo ($kh['id']==$dh['khachhang_id'])?'selected':''; ?>><?php echo htmlspecialchars($kh['ten']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="thoigian_dat" class="form-label">Thời gian đặt</label>
        <input type="datetime-local" name="thoigian_dat" id="thoigian_dat" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($dh['thoigian_dat'])); ?>" required>
    </div>
    <div class="mb-3">
        <label for="nhanvien_id" class="form-label">Nhân viên xử lý</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gioitinh" id="gt_nam" value="Nam" <?php echo ($nv['gioitinh']==='Nam')?'checked':''; ?>>
            <label class="form-check-label" for="gt_nam">Nam</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gioitinh" id="gt_nu" value="Nu" <?php echo ($nv['gioitinh']==='Nu')?'checked':''; ?>>
            <label class="form-check-label" for="gt_nu">Nữ</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gioitinh" id="gt_khac" value="Khac" <?php echo ($nv['gioitinh']==='Khac')?'checked':''; ?>>
            <label class="form-check-label" for="gt_khac">Khác</label>
        </div>
    </div>
    <div class="mb-3">
        <label for="sdt" class="form-label">Số điện thoại</label>
        <input type="text" name="sdt" id="sdt" class="form-control" value="<?php echo htmlspecialchars($nv['sdt']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($nv['email']); ?>">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="hoatdong" id="hoatdong" class="form-check-input" <?php echo ($nv['hoatdong'])?'checked':''; ?>>
        <label class="form-check-label" for="hoatdong">Đang hoạt động</label>
    </div>
    <button type="submit" class="btn btn-success">Lưu</button> <a href="list.php" class="btn btn-secondary">Hủy</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>

/* File: nhanvien/delete.php */
<?php
require_once __DIR__ . '/../config/db.php';
$id = isset($_GET['id'])? (int)$_GET['id']:0;
if($id){ $stmt=$pdo->prepare("DELETE FROM nhanvien WHERE id=:id"); $stmt->execute([':id'=>$id]); }
header('Location: list.php'); exit;
?>
