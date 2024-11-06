<?php
// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối tới cơ sở dữ liệu
require_once '../../Database/DBConnection.php';  

// Khai báo biến để lưu mã loại thuốc
$maLoaiThuocInput = '';
$hasResult = false; // Biến để kiểm tra có kết quả trả về hay không

// Kiểm tra xem có dữ liệu từ form gửi lên không
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maLoaiThuoc'])) {
    $maLoaiThuocInput = $_POST['maLoaiThuoc'];
}

try {
    // Tạo đối tượng kết nối
    $db = new DBConnection();
    $conn = $db->connect();

    if ($maLoaiThuocInput) {
        // Chuẩn bị câu lệnh gọi thủ tục
        $stmt = $conn->prepare("CALL ProcThongKeKeDon(:MaLoaiThuocInput)");
        $stmt->bindParam(':MaLoaiThuocInput', $maLoaiThuocInput, PDO::PARAM_STR);

        // Thực thi thủ tục
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $hasResult = true; // Có kết quả để hiển thị
        } else {
            echo "<div class='alert alert-warning' role='alert'>Không tìm thấy thuốc có mã: " . htmlspecialchars($maLoaiThuocInput) . "</div>";
        }

        // Đóng kết nối
        $stmt->closeCursor();
    } else {
        echo "<div class='alert alert-info' role='alert'>Vui lòng nhập mã loại thuốc để tìm kiếm.</div>";
    }

    // Đóng kết nối
    $db->disconnect();

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Phòng Khám Nhi</title>
    <!-- Thêm liên kết Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling cho Navbar */
        .navbar {
            margin-bottom: 30px;
        }

        .navbar .title {
            font-size: 24px;
            font-weight: bold;
        }

        /* Thêm styling cho bảng */
        table {
            margin-top: 20px;
        }

        th, td {
            text-align: center;
        }

        .alert {
            margin-top: 20px;
        }

        /* Styling cho form */
        .form-container {
            margin-top: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        /* Đảm bảo button không bị chật */
        .btn {
            margin-top: 15px;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-brand">Quản Lý Phòng Khám Nhi</div>
    </div>
</nav>

<!-- Form nhập mã loại thuốc -->
<div class="container form-container">
    <h3>Nhập Mã Loại Thuốc</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label for="maLoaiThuoc">Mã Loại Thuốc:</label>
            <input type="text" id="maLoaiThuoc" name="maLoaiThuoc" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
    </form>
</div>

<!-- Bảng dữ liệu -->
<div class="container">
    <?php if ($hasResult) { ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã Loại Thuốc</th>
                    <th>Tên Loại Thuốc</th>
                    <th>Số Lượt Kê Đơn</th>
                    <th>Tổng Số Lượng Thuốc</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stmt = $conn->prepare("CALL ProcThongKeKeDon(:MaLoaiThuocInput)");
                $stmt->bindParam(':MaLoaiThuocInput', $maLoaiThuocInput, PDO::PARAM_STR);
                $stmt->execute();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['MaLoaiThuoc']); ?></td>
                        <td><?php echo htmlspecialchars($row['TenLoaiThuoc']); ?></td>
                        <td><?php echo htmlspecialchars($row['SoLuotKeDon']); ?></td>
                        <td><?php echo htmlspecialchars($row['TongSoLuongThuoc']); ?></td>
                    </tr>
                <?php }
                $stmt->closeCursor();
                ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<!-- Thêm liên kết Bootstrap JS và jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
