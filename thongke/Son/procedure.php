<?php
// Gọi file db.php để kết nối với cơ sở dữ liệu
include '../../Database/DBConnection.php';

try {
    // Khởi tạo đối tượng kết nối
    $db = new DBConnection();
    $conn = $db->connect();

    // Kiểm tra nếu kết nối thành công
    if ($conn) {
        // Lấy mã thuốc từ form (nếu có)
        $maThuoc = isset($_POST['MaThuoc']) ? $_POST['MaThuoc'] : null;

        // Gọi procedure SoLuongThuocConTrongKho
        if ($maThuoc) {
            // Nếu có mã thuốc, gọi procedure với tham số
            $sql = "EXEC SoLuongThuocConTrongKho @MaThuoc = :maThuoc";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':maThuoc', $maThuoc, PDO::PARAM_STR);
        } else {
            // Nếu không có mã thuốc, gọi procedure không có tham số
            $sql = "EXEC SoLuongThuocConTrongKho";
            $stmt = $conn->prepare($sql);
        }

        // Thực thi câu lệnh
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        throw new Exception("Kết nối cơ sở dữ liệu không thành công.");
    }
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Danh sách Số Lượng Thuốc Còn Trong Kho</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Quản lý thuốc</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../../home/home.php">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../ThongKe.php">Quay lại</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Danh sách Số Lượng Thuốc Còn Trong Kho</h2>

    <!-- Form để nhập mã thuốc -->
    <form method="POST" action="procedure.php" class="form-inline justify-content-center mb-4">
        <div class="form-group">
            <label for="MaThuoc" class="mr-2">Nhập Mã Thuốc:</label>
            <input type="text" id="MaThuoc" name="MaThuoc" class="form-control mr-2" value="<?php echo isset($maThuoc) ? htmlspecialchars($maThuoc) : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Xem</button>
    </form>

    <!-- Bảng hiển thị dữ liệu -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã Thuốc</th>
                    <th>Tên Thuốc</th>
                    <th>Số Lượng Trong Kho</th>
                    <th>Số Lượng Đã Bán</th>
                    <th>Số Lượng Còn Lại</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kiểm tra và hiển thị dữ liệu nếu có
                if (!empty($results)) {
                    foreach ($results as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["MaThuoc"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["TenThuoc"]) . "</td>";
                        echo "<td>" . number_format($row["SoLuongThuocTrongKho"], 0, ',', '.') . "</td>";
                        echo "<td>" . number_format($row["SoLuongBan"], 0, ',', '.') . "</td>";
                        echo "<td>" . number_format($row["SoLuongConLai"], 0, ',', '.') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Đóng kết nối
$conn = null;
?>