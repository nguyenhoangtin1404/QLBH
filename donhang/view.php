<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin đơn hàng chính
$sql = "SELECT dh.*, kh.ten AS ten_kh, nv.ten AS ten_nv, mg.ma AS ma_giam, mg.giam_phantram, mg.giam_tien FROM donhang dh 
        JOIN khachhang kh ON dh.khachhang_id = kh.id 
        JOIN nhanvien nv ON dh.nhanvien_id = nv.id 
        LEFT JOIN ma_giam_gia mg ON dh.ma_giam_gia_id = mg.id 
        WHERE dh.id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$dh = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dh) {
    echo '<div class="alert alert-danger">Không tìm thấy đơn hàng.</div>';
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}

// Lấy chi tiết sản phẩm trong đơn hàng
$sql_ct = "SELECT ctdh.*, sp.ten AS ten_sp FROM chi_tiet_donhang ctdh JOIN sanpham sp ON ctdh.sanpham_id = sp.id WHERE ctdh.donhang_id = :id";
$stmt_ct = $pdo->prepare($sql_ct);
$stmt_ct->execute([':id' => $id]);
$ctdh_list = $stmt_ct->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Chi tiết Đơn hàng #<?php echo htmlspecialchars($dh['id']); ?></h2>
<div class="mb-3">
    <strong>Khách hàng:</strong> <?php echo htmlspecialchars($dh['ten_kh']); ?><br>
    <strong>Nhân viên:</strong> <?php echo htmlspecialchars($dh['ten_nv']); ?><br>
    <strong>Thời gian đặt:</strong> <?php echo htmlspecialchars($dh['thoigian_dat']); ?><br>
    <strong>Mã giảm giá:</strong> <?php echo $dh['ma_giam'] ? htmlspecialchars($dh['ma_giam']) : 'Không'; ?><br>
    <?php if ($dh['ma_giam']): ?>
        <strong>Giảm %:</strong> <?php echo htmlspecialchars($dh['giam_phantram']); ?>%<br>
        <strong>Giảm tiền:</strong> <?php echo $dh['giam_tien'] ? number_format($dh['giam_tien'], 0, ',', '.') . ' đ' : '0 đ'; ?><br>
    <?php endif; ?>
    <strong>Tổng tiền:</strong> <?php echo number_format($dh['tong_tien'], 0, ',', '.') . ' đ'; ?><br>
    <strong>Đã thanh toán:</strong> <?php echo number_format($dh['tien_thanh_toan'], 0, ',', '.') . ' đ'; ?><br>
</div>
<h4>Sản phẩm:</h4>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá bán thực tế</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ctdh_list as $index => $item): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($item['ten_sp']); ?></td>
                <td><?php echo htmlspecialchars($item['so_luong']); ?></td>
                <td><?php echo number_format($item['gia_ban_thuc_te'], 0, ',', '.') . ' đ'; ?></td>
                <td><?php echo number_format($item['so_luong'] * $item['gia_ban_thuc_te'], 0, ',', '.') . ' đ'; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="edit.php?id=<?php echo $dh['id']; ?>" class="btn btn-warning">Sửa đơn hàng</a>
<a href="list.php" class="btn btn-secondary">Quay lại danh sách</a>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>