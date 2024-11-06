<?php
// Gọi file db.php để kết nối với cơ sở dữ liệu
include '../../Database/DBConnection.php';

try {
    // Khởi tạo đối tượng kết nối
    $db = new DBConnection();
    $conn = $db->connect();

    // Kiểm tra nếu kết nối thành công
    if ($conn) {
        // Lấy mã xét nghiệm từ form (nếu có)
        $maXetNghiem = isset($_GET['MaXetNghiem']) ? $_GET['MaXetNghiem'] : null;

        // Gọi hàm fn_BenhNhanThamGiaXetNghiem nếu có mã xét nghiệm
        if ($maXetNghiem) {
            $sql = "SELECT * FROM fn_BenhNhanThamGiaXetNghiem(:maXetNghiem)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':maXetNghiem', $maXetNghiem, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $results = [];
        }
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
    <title>Danh sách Bệnh Nhân Tham Gia Xét Nghiệm</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Quản lý xét nghiệm</a>
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
    <h2 class="text-center mb-4">Danh sách Bệnh Nhân Tham Gia Xét Nghiệm</h2>

    <!-- Form để nhập mã xét nghiệm -->
    <form method="get" action="function.php" class="form-inline justify-content-center mb-4">
        <div class="form-group">
            <label for="MaXetNghiem" class="mr-2">Nhập Mã Xét Nghiệm:</label>
            <input type="text" id="MaXetNghiem" name="MaXetNghiem" class="form-control mr-2" value="<?php echo isset($maXetNghiem) ? htmlspecialchars($maXetNghiem) : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Xem</button>
    </form>

    <!-- Bảng hiển thị dữ liệu -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã Bệnh Nhân</th>
                    <th>Tên Bệnh Nhân</th>
                    <th>Giới Tính</th>
                    <th>Ngày Sinh</th>
                    <th>Địa Chỉ</th>
                    <th>Số Điện Thoại</th>
                    <th>Mã Xét Nghiệm</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Kiểm tra và hiển thị dữ liệu nếu có
                if (!empty($results)) {
                    foreach ($results as $row) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["MaBenhNhan"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["TenBenhNhan"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["GioiTinh"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["NgaySinh"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["DiaChi"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["SoDienThoai"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["MaXetNghiem"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
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