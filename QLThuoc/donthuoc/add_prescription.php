<?php
session_start(); // Khởi động phiên

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Chuyển hướng về trang đăng nhập
    exit();
}

require_once '../../Database/DBConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maDon = $_POST['maDon'];
    $maPhieuKham = $_POST['maPhieuKham'];

    $db = new DBConnection();
    $conn = $db->connect();

    $stmt = $conn->prepare("INSERT INTO donthuoc (MaDon, MaPhieuKham) VALUES (:maDon, :maPhieuKham)");
    $stmt->execute(['maDon' => $maDon, 'maPhieuKham' => $maPhieuKham]);

    header("Location: donthuoc.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Đơn Thuốc Mới</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Thêm Đơn Thuốc Mới</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="maDon">Mã Đơn Thuốc</label>
                <input type="text" class="form-control" id="maDon" name="maDon" required>
            </div>
            <div class="form-group">
                <label for="maPhieuKham">Mã Phiếu Khám</label>
                <input type="text" class="form-control" id="maPhieuKham" name="maPhieuKham" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm Đơn Thuốc</button>
        </form>
    </div>

    <!-- Bootstrap JS và các thư viện phụ thuộc -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
