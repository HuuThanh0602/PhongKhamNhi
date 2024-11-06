<?php
session_start();
require_once '../../Database/DBConnection.php';

$db = new DBConnection();
$conn = $db->connect();  // Kết nối đến cơ sở dữ liệu

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maBenhNhan = $_POST['maBenhNhan'];
    $tenBenhNhan = $_POST['tenBenhNhan'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $tenNguoiThan = $_POST['tenNguoiThan'];
    $soCCCDNguoiThan = $_POST['soCCCDNguoiThan'];
    $diaChi = $_POST['diaChi'];
    $soDienThoai = $_POST['soDienThoai'];
    $ngayHenKham = $_POST['ngayHenKham'];

    // Chuẩn bị câu lệnh SQL để thêm dữ liệu
    $stmt = $conn->prepare("INSERT INTO BenhNhan (MaBenhNhan, TenBenhNhan, GioiTinh, NgaySinh, TenNguoiThan, SoCCCDNguoiThan, DiaChi, SoDienThoai, NgayHenKham) 
                            VALUES (:maBenhNhan, :tenBenhNhan, :gioiTinh, :ngaySinh, :tenNguoiThan, :soCCCDNguoiThan, :diaChi, :soDienThoai, :ngayHenKham)");

    // Thực thi câu lệnh SQL
    $stmt->execute([
        'maBenhNhan' => $maBenhNhan,
        'tenBenhNhan' => $tenBenhNhan,
        'gioiTinh' => $gioiTinh,
        'ngaySinh' => $ngaySinh,
        'tenNguoiThan' => $tenNguoiThan,
        'soCCCDNguoiThan' => $soCCCDNguoiThan,
        'diaChi' => $diaChi,
        'soDienThoai' => $soDienThoai,
        'ngayHenKham' => $ngayHenKham
    ]);

    // Thông báo và chuyển hướng sau khi thêm thành công
    $_SESSION['message'] = "Bệnh nhân đã được thêm thành công!";
    header("Location: benhnhan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Thêm Bệnh Nhân</title>
    <link rel="stylesheet" href="../../accset/css/bootstrap.min.css">
    <script src="../../accset/js/jquery-3.5.1.min.js"></script>
    <script src="../../accset/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg shadow p-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="benhnhan.php">Quay lại</a>
        </div>
    </nav>
</header>

<div class="container mt-5">
    <h2 class="text-center">Thêm Bệnh Nhân Mới</h2>

    <!-- Hiển thị thông báo nếu có -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-success'>{$_SESSION['message']}</div>";
        unset($_SESSION['message']);
    }
    ?>

    <!-- Form nhập thông tin bệnh nhân -->
    <form action="add.php" method="post">
        <div class="form-group">
            <label for="maBenhNhan">Mã Bệnh Nhân</label>
            <input type="text" class="form-control" id="maBenhNhan" name="maBenhNhan" required>
        </div>

        <div class="form-group">
            <label for="tenBenhNhan">Tên Bệnh Nhân</label>
            <input type="text" class="form-control" id="tenBenhNhan" name="tenBenhNhan" required>
        </div>

        <div class="form-group">
            <label for="gioiTinh">Giới Tính</label>
            <select class="form-control" id="gioiTinh" name="gioiTinh" required>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ngaySinh">Ngày Sinh</label>
            <input type="date" class="form-control" id="ngaySinh" name="ngaySinh" required>
        </div>

        <div class="form-group">
            <label for="tenNguoiThan">Tên Người Thân</label>
            <input type="text" class="form-control" id="tenNguoiThan" name="tenNguoiThan" required>
        </div>

        <div class="form-group">
            <label for="soCCCDNguoiThan">Số CCCD Người Thân</label>
            <input type="text" class="form-control" id="soCCCDNguoiThan" name="soCCCDNguoiThan" required>
        </div>

        <div class="form-group">
            <label for="diaChi">Địa Chỉ</label>
            <input type="text" class="form-control" id="diaChi" name="diaChi" required>
        </div>

        <div class="form-group">
            <label for="soDienThoai">Số Điện Thoại</label>
            <input type="text" class="form-control" id="soDienThoai" name="soDienThoai" required>
        </div>

        <div class="form-group">
            <label for="ngayHenKham">Ngày Hẹn Khám</label>
            <input type="date" class="form-control" id="ngayHenKham" name="ngayHenKham" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm Bệnh Nhân</button>
    </form>
</div>

</body>
</html>
