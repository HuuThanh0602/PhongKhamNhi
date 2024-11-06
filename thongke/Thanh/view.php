<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Bệnh Nhân</title>
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
        <div class="navbar-brand">Quản Lý Bệnh Nhân</div>
        <div><a href="../ThongKe.php" class="text-white">Quay Lại</a></div>
    </div>
</nav>

<div class="container">
    <!-- Form tìm kiếm -->
    <form method="GET" class="form-inline mb-3">
        <input type="text" class="form-control mr-2" name="search" placeholder="Tìm kiếm theo tên bệnh nhân" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>

    <?php
    require_once '../../Database/DBConnection.php';

    try {
        // Tạo đối tượng kết nối
        $db = new DBConnection();
        $conn = $db->connect();

        // Lấy giá trị tìm kiếm từ form (nếu có)
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Truy vấn dữ liệu từ view ThongKeBN và áp dụng điều kiện tìm kiếm
        $sql = "SELECT * FROM ThongKeBN WHERE TenBenhNhan LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['search' => '%' . $search . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kiểm tra và hiển thị dữ liệu
        if (count($results) > 0) {
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='thead-dark'>";
            echo "<tr><th>Mã Bệnh Nhân</th><th>Tên Bệnh Nhân</th><th>Giới Tính</th><th>Ngày Sinh</th><th>Tên Người Thân</th><th>Số Điện Thoại</th><th>Địa Chỉ</th><th>Tiền Thuốc</th><th>Tiền Xét Nghiệm</th><th>Tổng Tiền</th><th>Số Lần Khám</th></tr>";
            echo "</thead><tbody>";

            // Duyệt qua kết quả và hiển thị trong bảng
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['MaBenhNhan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TenBenhNhan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['GioiTinh']) . "</td>";
                echo "<td>" . htmlspecialchars($row['NgaySinh']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TenNguoiThan']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SoDienThoai']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DiaChi']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TienThuoc']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TienXetNghiem']) . "</td>";
                echo "<td>" . htmlspecialchars($row['TongTien']) . "</td>";
                echo "<td>" . htmlspecialchars($row['SolanKham']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning' role='alert'>Không có dữ liệu phù hợp với tìm kiếm.</div>";
        }

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
