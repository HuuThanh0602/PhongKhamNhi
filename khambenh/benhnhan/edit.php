<?php
require_once '../../Database/DBConnection.php';

if (!isset($_GET['id'])) {
    die("Missing patient ID.");
}

$id = $_GET['id'];

$db = new DBConnection();
$conn = $db->connect();

// Fetch patient data based on ID
$query = "SELECT * FROM BenhNhan WHERE MaBenhNhan = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$patient = $stmt->fetch();

if (!$patient) {
    die("Patient not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission to update patient data
    $tenBenhNhan = $_POST['TenBenhNhan'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $tenNguoiThan = $_POST['TenNguoiThan'];
    $soCCCDNguoiThan = $_POST['SoCCCDNguoiThan'];
    $diaChi = $_POST['DiaChi'];
    $soDienThoai = $_POST['SoDienThoai'];
    $ngayHenKham = $_POST['NgayHenKham'];

    $updateQuery = "UPDATE BenhNhan SET 
        TenBenhNhan = :tenBenhNhan, 
        GioiTinh = :gioiTinh, 
        NgaySinh = :ngaySinh, 
        TenNguoiThan = :tenNguoiThan, 
        SoCCCDNguoiThan = :soCCCDNguoiThan, 
        DiaChi = :diaChi, 
        SoDienThoai = :soDienThoai, 
        NgayHenKham = :ngayHenKham
        WHERE MaBenhNhan = :id";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bindParam(':tenBenhNhan', $tenBenhNhan);
    $stmt->bindParam(':gioiTinh', $gioiTinh);
    $stmt->bindParam(':ngaySinh', $ngaySinh);
    $stmt->bindParam(':tenNguoiThan', $tenNguoiThan);
    $stmt->bindParam(':soCCCDNguoiThan', $soCCCDNguoiThan);
    $stmt->bindParam(':diaChi', $diaChi);
    $stmt->bindParam(':soDienThoai', $soDienThoai);
    $stmt->bindParam(':ngayHenKham', $ngayHenKham);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $_SESSION['message'] = 'Sửa thành công';
    header('Location: benhnhan.php'); // Redirect to the patients list
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Chỉnh sửa Bệnh Nhân</title>
    <link rel="stylesheet" href="../../accset/css/bootstrap.min.css">
    <script src="../../accset/js/jquery-3.5.1.min.js"></script>
    <script src="../../accset/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Chỉnh sửa thông tin bệnh nhân</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="TenBenhNhan">Tên Bệnh Nhân</label>
            <input type="text" name="TenBenhNhan" id="TenBenhNhan" class="form-control" value="<?= htmlspecialchars($patient['TenBenhNhan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="GioiTinh">Giới Tính</label>
            <select name="GioiTinh" id="GioiTinh" class="form-control" required>
                <option value="Nam" <?= $patient['GioiTinh'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="Nữ" <?= $patient['GioiTinh'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="NgaySinh">Ngày Sinh</label>
            <input type="date" name="NgaySinh" id="NgaySinh" class="form-control" value="<?= htmlspecialchars($patient['NgaySinh']); ?>" required>
        </div>
        <div class="form-group">
            <label for="TenNguoiThan">Tên Người Thân</label>
            <input type="text" name="TenNguoiThan" id="TenNguoiThan" class="form-control" value="<?= htmlspecialchars($patient['TenNguoiThan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="SoCCCDNguoiThan">Số CCCD Người Thân</label>
            <input type="text" name="SoCCCDNguoiThan" id="SoCCCDNguoiThan" class="form-control" value="<?= htmlspecialchars($patient['SoCCCDNguoiThan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="DiaChi">Địa Chỉ</label>
            <input type="text" name="DiaChi" id="DiaChi" class="form-control" value="<?= htmlspecialchars($patient['DiaChi']); ?>" required>
        </div>
        <div class="form-group">
            <label for="SoDienThoai">Số Điện Thoại</label>
            <input type="text" name="SoDienThoai" id="SoDienThoai" class="form-control" value="<?= htmlspecialchars($patient['SoDienThoai']); ?>" required>
        </div>
        <div class="form-group">
            <label for="NgayHenKham">Ngày Hẹn Khám</label>
            <input type="date" name="NgayHenKham" id="NgayHenKham" class="form-control" value="<?= htmlspecialchars($patient['NgayHenKham']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </form>
</div>

</body>
</html>
