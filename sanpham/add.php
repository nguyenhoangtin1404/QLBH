<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';
$stmtHs = $pdo->query("SELECT id, ten_hang FROM hang_san_xuat ORDER BY ten_hang");
hangsx_list = $stmtHs->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = trim($_POST['ten']);
    $mota = trim($_POST['mota']);
    $tile = $_POST['tile'];
    $hangsx_id = $_POST['hangsx_id'];
    $gia_preorder = str_replace([',','.'],['',''],$_POST['gia_preorder']);
    $gia_ban = str_replace([',','.'],['',''],$_POST['gia_ban']);
    $ngay_phat_hanh = $_POST['ngay_phat_hanh'];
    $so_luong_ton = (int)$_POST['so_luong_ton'];
    $diem_tich_luy = (int)$_POST['diem_tich_luy'];
    $sql = "INSERT INTO sanpham (ten, mota, tile, hangsx_id, gia_preorder, gia_ban, ngay_phat_hanh, so_luong_ton, so_luong_ban, diem_tich_luy) VALUES (:ten, :mota, :tile, :hangsx_id, :gia_preorder, :gia_ban, :ngay_phat_hanh, :so_luong_ton, 0, :diem_tich_luy)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':ten'=>$ten,':mota'=>$mota,':tile'=>$tile,':hangsx_id'=>$hangsx_id,':gia_preorder'=>$gia_preorder,':gia_ban'=>$gia_ban,':ngay_phat_hanh'=>$ngay_phat_hanh,':so_luong_ton'=>$so_luong_ton,':diem_tich_luy'=>$diem_tich_luy]);
    header('Location: list.php'); exit;
}
?>
<h2>Thêm mới Sản phẩm</h2>
<form method="post" action="add.php">
    <div class="mb-3">
        <label for="ten" class="form-label">Tên sản phẩm</label>
        <input type="text" name="ten" id="ten" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="mota" class="form-label">Mô tả</label>
        <textarea name="mota" id="mota" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="tile" class="form-label">Tỉ lệ</label>
        <input type="text" name="tile" id="tile" class="form-control">
    </div>
    <div class="mb-3">
        <label for="hangsx_id" class="form-label">Hãng sản xuất</label>
        <select name="hangsx_id" id="hangsx_id" class="form-select" required>
            <option value="">-- Chọn hãng --</option>
            <?php foreach ($hangsx_list as $hs): ?>
                <option value="<?php echo $hs['id']; ?>"><?php echo htmlspecialchars($hs['ten_hang']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="gia_preorder" class="form-label">Giá Pre-order</label>
        <input type="text" name="gia_preorder" id="gia_preorder" class="form-control">
    </div>
    <div class="mb-3">
        <label for="gia_ban" class="form-label">Giá bán</label>
        <input type="text" name="gia_ban" id="gia_ban" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="ngay_phat_hanh" class="form-label">Ngày phát hành</label>
        <input type="date" name="ngay_phat_hanh" id="ngay_phat_hanh" class="form-control">
    </div>
    <div class="mb-3">
        <label for="so_luong_ton" class="form-label">Số lượng tồn</label>
        <input type="number" name="so_luong_ton" id="so_luong_ton" class="form-control" value="0" min="0">
    </div>
    <div class="mb-3">
        <label for="diem_tich_luy" class="form-label">Điểm tích lũy</label>
        <input type="number" name="diem_tich_luy" id="diem_tich_luy" class="form-control" value="0" min="0">
    </div>
    <button type="submit" class="btn btn-success">Lưu</button> <a href="list.php" class="btn btn-secondary">Hủy</a>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
