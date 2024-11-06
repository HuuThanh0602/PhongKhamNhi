<?php
session_start();
require_once '../../Database/DBConnection.php';

// Kiểm tra nếu có dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $maPhieuKham = $_POST['maPhieuKham'];
    $maBenhNhan = $_POST['maBenhNhan'];
    $maNhanVien = $_POST['maNhanVien'];
    $lyDoKhamBenh = $_POST['lyDoKhamBenh'];
    $chuanDoan = $_POST['chuanDoan'];
    $ngayLamPhieu = $_POST['ngayLamPhieu'];
    $ketLuan = $_POST['ketLuan'];

    // Kết nối cơ sở dữ liệu
    $db = new DBConnection();
    $conn = $db->connect();

    // Câu lệnh thêm dữ liệu vào bảng PhieuKham
    $query = "INSERT INTO PhieuKham (MaPhieuKham, MaBenhNhan, MaNhanVien, LyDoKhamBenh, ChuanDoan, NgayLamPhieu, KetLuan) 
              VALUES (:maPhieuKham, :maBenhNhan, :maNhanVien, :lyDoKhamBenh, :chuanDoan, :ngayLamPhieu, :ketLuan)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':maPhieuKham', $maPhieuKham, PDO::PARAM_STR);
    $stmt->bindParam(':maBenhNhan', $maBenhNhan, PDO::PARAM_STR);
    $stmt->bindParam(':maNhanVien', $maNhanVien, PDO::PARAM_STR);
    $stmt->bindParam(':lyDoKhamBenh', $lyDoKhamBenh, PDO::PARAM_STR);
    $stmt->bindParam(':chuanDoan', $chuanDoan, PDO::PARAM_STR);
    $stmt->bindParam(':ngayLamPhieu', $ngayLamPhieu, PDO::PARAM_STR);
    $stmt->bindParam(':ketLuan', $ketLuan, PDO::PARAM_STR);

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Thêm phiếu khám thành công!';
        header('Location: phieukham.php');
        exit();
    } else {
        $_SESSION['message'] = 'Lỗi khi thêm phiếu khám!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Phiếu Khám</title>
    <link rel="stylesheet" href="../../accset/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Thêm Phiếu Khám Mới</h2>

    <!-- Hiển thị thông báo -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <!-- Form thêm phiếu khám -->
    <form action="" method="post">
        <div class="form-group">
            <label for="maPhieuKham">Mã Phiếu Khám</label>
            <input type="text" class="form-control" id="maPhieuKham" name="maPhieuKham" required>
        </div>
        <div class="form-group">
            <label for="maBenhNhan">Mã Bệnh Nhân</label>
            <input type="text" class="form-control" id="maBenhNhan" name="maBenhNhan" required>
        </div>
        <div class="form-group">
            <label for="maNhanVien">Mã Nhân Viên</label>
            <input type="text" class="form-control" id="maNhanVien" name="maNhanVien" required>
        </div>
        <div class="form-group">
            <label for="lyDoKhamBenh">Lý Do Khám</label>
            <input type="text" class="form-control" id="lyDoKhamBenh" name="lyDoKhamBenh" required>
        </div>
        <div class="form-group">
            <label for="chuanDoan">Chuẩn Đoán</label>
            <input type="text" class="form-control" id="chuanDoan" name="chuanDoan" required>
        </div>
        <div class="form-group">
            <label for="ngayLamPhieu">Ngày Làm Phiếu</label>
            <input type="date" class="form-control" id="ngayLamPhieu" name="ngayLamPhieu" required>
        </div>
        <div class="form-group">
            <label for="ketLuan">Kết Luận</label>
            <input type="text" class="form-control" id="ketLuan" name="ketLuan" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm Phiếu Khám</button>
    </form>
</div>

</body>
</html>
