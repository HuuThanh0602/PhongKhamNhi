<?php
// Gọi file db.php để kết nối với cơ sở dữ liệu
include '../../Database/DBConnection.php';

try {
    // Khởi tạo đối tượng kết nối
    $db = new DBConnection();
    $conn = $db->connect();

    // Kiểm tra nếu kết nối thành công
    if ($conn) {
        // Truy vấn dữ liệu từ view PhieuThu
        $sql = "SELECT * FROM PhieuThu";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Lấy tất cả các dòng dữ liệu
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
    <title>Danh sách Phiếu Thu</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Quản lý bệnh viện</a>
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
    <h2 class="text-center mb-4">Danh sách Phiếu Thu</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Tên Bệnh Nhân</th>
                    <th>Tổng Tiền Xét Nghiệm</th>
                    <th>Tổng Tiền Thuốc</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kiểm tra và hiển thị dữ liệu nếu có
                if (!empty($results)) {
                    foreach ($results as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["TenBenhNhan"]) . "</td>";
                        echo "<td>" . number_format($row["TongTienXetNghiem"], 0, ',', '.') . " đ</td>";
                        echo "<td>" . number_format($row["TongTienThuoc"], 0, ',', '.') . " đ</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
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