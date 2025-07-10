<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Danh sách Sản phẩm</h2>
<a href="add.php" class="btn btn-primary mb-3">Thêm sản phẩm</a>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Hãng sản xuất</th>
            <th>Giá bán</th>
            <th>Số lượng tồn</th>
            <th>Số lượng bán</th>
            <th>Điểm tích lũy</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT sp.*, hs.ten_hang FROM sanpham sp JOIN hang_san_xuat hs ON sp.hangsx_id = hs.id ORDER BY sp.id DESC";
        $stmt = $pdo->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ten']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ten_hang']) . '</td>';
            echo '<td>' . number_format($row['gia_ban'], 0, ',', '.') . '</td>';
            echo '<td>' . htmlspecialchars($row['so_luong_ton']) . '</td>';
            echo '<td>' . htmlspecialchars($row['so_luong_ban']) . '</td>';
            echo '<td>' . htmlspecialchars($row['diem_tich_luy']) . '</td>';
            echo '<td>';
            echo '<a href="edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning me-1">Sửa</a>';
            echo '<a href="delete.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes<footer.php'; ?>