<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Danh sách Nhân viên</h2>
<a href="add.php" class="btn btn-primary mb-3">Thêm nhân viên</a>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Doanh thu</th>
            <th>Giới tính</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Hoạt động</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->query("SELECT * FROM nhanvien ORDER BY id DESC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ten']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ngaysinh']) . '</td>';
            echo '<td>' . number_format($row['doanhthu'], 0, ',', '.') . '</td>';
            echo '<td>' . htmlspecialchars($row['gioitinh']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sdt']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . ($row['hoatdong'] ? 'Active' : 'Inactive') . '</td>';
            echo '<td>';
            echo '<a href="edit.php?id=' . $row['id'] . '" class="btn btn-sm btn-warning me-1">Sửa</a>';
            echo '<a href="delete.php?id=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Bạn có chắc muốn xóa?\')">Xóa</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>