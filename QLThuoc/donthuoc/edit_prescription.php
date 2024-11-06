<?php
session_start(); // Khởi động phiên

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Chuyển hướng về trang đăng nhập
    exit();
}

require_once '../../Database/DBConnection.php';

$db = new DBConnection();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maDon = $_POST['maDon'];
    $maPhieuKham = $_POST['maPhieuKham'];

    $stmt = $conn->prepare("UPDATE donthuoc SET MaPhieuKham = :maPhieuKham WHERE MaDon = :maDon");
    $stmt->execute(['maDon' => $maDon, 'maPhieuKham' => $maPhieuKham]);

    header("Location: donthuoc.php");
    exit();
} else {
    $maDon = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM donthuoc WHERE MaDon = :maDon");
    $stmt->execute(['maDon' => $maDon]);
    $prescription = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Đơn Thuốc</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Chỉnh Sửa Đơn Thuốc</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="maDon">Mã Đơn Thuốc</label>
                <input type="text" class="form-control" id="maDon" name="maDon" value="<?php echo htmlspecialchars($prescription['MaDon']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="maPhieuKham">Mã Phiếu Khám</label>
                <input type="text" class="form-control" id="maPhieuKham" name="maPhieuKham" value="<?php echo htmlspecialchars($prescription['MaPhieuKham']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật Đơn Thuốc</button>
        </form>
    </div>

    <!-- Bootstrap JS và các thư viện phụ thuộc -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
