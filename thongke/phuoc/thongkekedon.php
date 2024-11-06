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
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-brand">Quản Lý Phòng Khám Nhi</div>
    </div>
</nav>

<div class="container">
    <?php
    require_once '../../Database/DBConnection.php';

    try {
        // Tạo đối tượng kết nối
        $db = new DBConnection();
        $conn = $db->connect();

        // Truy vấn dữ liệu từ view ThongKeKeDon
        $sql = "SELECT MaLoaiThuoc, TenLoaiThuoc, SoLuotKeDon, TongSoLuongThuoc FROM ThongKeKeDon";
        $stmt = $conn->query($sql);

        // Kiểm tra và hiển thị dữ liệu
        if ($stmt->rowCount() > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='thead-dark'>";
            echo "<tr><th>Mã Loại Thuốc</th><th>Tên Loại Thuốc</th><th>Số Lượt Kê Đơn</th><th>Tổng Số Lượng Thuốc</th></tr>";
            echo "</thead><tbody>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['MaLoaiThuoc']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TenLoaiThuoc']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SoLuotKeDon']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TongSoLuongThuoc']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning' role='alert'>Không có dữ liệu trong view ThongKeKeDon.</div>";
        }

        // Ngắt kết nối
        $db->disconnect();

    } catch (Exception $e) {
        echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $e->getMessage() . "</div>";
    }
    ?>
</div>

<!-- Thêm liên kết Bootstrap JS và jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
