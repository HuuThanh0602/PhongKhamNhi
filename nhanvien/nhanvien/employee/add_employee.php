<?php
require_once '../DBConnection.php';

if (isset($_POST['submit'])) {
    $db = new DBConnection();
    $conn = $db->connect();

    // Chuẩn bị và thực thi câu lệnh thêm nhân viên
    $stmt = $conn->prepare("INSERT INTO NhanVien (MaNhanVien, HoTen, NgaySinh, GioiTinh, DiaChi, SoDienThoai, SoCCCD, TrinhDo, ChucVu, NgayVaoLam, MucLuong, PhuCap)
                            VALUES (:MaNhanVien, :HoTen, :NgaySinh, :GioiTinh, :DiaChi, :SoDienThoai, :SoCCCD, :TrinhDo, :ChucVu, :NgayVaoLam, :MucLuong, :PhuCap)");

    $stmt->execute([
        'MaNhanVien' => $_POST['MaNhanVien'], // Lấy giá trị từ form
        'HoTen' => $_POST['HoTen'],
        'NgaySinh' => $_POST['NgaySinh'],
        'GioiTinh' => $_POST['GioiTinh'],
        'DiaChi' => $_POST['DiaChi'],
        'SoDienThoai' => $_POST['SoDienThoai'],
        'SoCCCD' => $_POST['SoCCCD'],
        'TrinhDo' => $_POST['TrinhDo'],
        'ChucVu' => $_POST['ChucVu'],
        'NgayVaoLam' => $_POST['NgayVaoLam'],
        'MucLuong' => $_POST['MucLuong'],
        'PhuCap' => $_POST['PhuCap'],
    ]);

    // Chuyển hướng về trang quản lý nhân viên sau khi thêm thành công
    header("Location: employee_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Thêm Nhân Viên</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="MaNhanVien">Mã Nhân Viên</label>
                <input type="text" class="form-control" id="MaNhanVien" name="MaNhanVien" required>
            </div>
            <div class="form-group">
                <label for="HoTen">Họ Tên</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" required>
            </div>
            <div class="form-group">
                <label for="NgaySinh">Ngày Sinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required>
            </div>
            <div class="form-group">
                <label for="GioiTinh">Giới Tính</label>
                <select class="form-control" id="GioiTinh" name="GioiTinh" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="DiaChi">Địa Chỉ</label>
                <input type="text" class="form-control" id="DiaChi" name="DiaChi" required>
            </div>
            <div class="form-group">
                <label for="SoDienThoai">Số Điện Thoại</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai" required>
            </div>
            <div class="form-group">
                <label for="SoCCCD">CCCD</label>
                <input type="text" class="form-control" id="SoCCCD" name="SoCCCD" required>
            </div>
            <div class="form-group">
                <label for="TrinhDo">Trình Độ</label>
                <input type="text" class="form-control" id="TrinhDo" name="TrinhDo" required>
            </div>
            <div class="form-group">
                <label for="ChucVu">Chức Vụ</label>
                <input type="text" class="form-control" id="ChucVu" name="ChucVu" required>
            </div>
            <div class="form-group">
                <label for="NgayVaoLam">Ngày Vào Làm</label>
                <input type="date" class="form-control" id="NgayVaoLam" name="NgayVaoLam" required>
            </div>
            <div class="form-group">
                <label for="MucLuong">Lương</label>
                <input type="number" class="form-control" id="MucLuong" name="MucLuong" required>
            </div>
            <div class="form-group">
                <label for="PhuCap">Phụ Cấp</label>
                <input type="number" class="form-control" id="PhuCap" name="PhuCap" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Thêm Nhân Viên</button>
        </form>
    </div>
</body>
</html>
