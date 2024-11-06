<?php
                require_once '../../Database/DBConnection.php';

if (isset($_GET['id'])) {
    $db = new DBConnection();
    $conn = $db->connect();
    $stmt = $conn->prepare("SELECT * FROM NhanVien WHERE MaNhanVien = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        header("Location: employee_management.php");
        exit();
    }
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE NhanVien SET HoTen = :HoTen, NgaySinh = :NgaySinh, GioiTinh = :GioiTinh, DiaChi = :DiaChi, SoDienThoai = :SoDienThoai, SoCCCD = :SoCCCD, TrinhDo = :TrinhDo, ChucVu = :ChucVu, NgayVaoLam = :NgayVaoLam, MucLuong = :MucLuong, PhuCap = :PhuCap WHERE MaNhanVien = :id");

    $stmt->execute([
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
        'id' => $_POST['id'],
    ]);

    header("Location: employee_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Nhân Viên</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Sửa Nhân Viên</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $employee['MaNhanVien']; ?>">
            <div class="form-group">
                <label for="HoTen">Họ Tên</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?php echo $employee['HoTen']; ?>" required>
            </div>
            <div class="form-group">
                <label for="NgaySinh">Ngày Sinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?php echo $employee['NgaySinh']; ?>" required>
            </div>
            <div class="form-group">
                <label for="GioiTinh">Giới Tính</label>
                <select class="form-control" id="GioiTinh" name="GioiTinh" required>
                    <option value="Nam" <?php if($employee['GioiTinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if($employee['GioiTinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label for="DiaChi">Địa Chỉ</label>
                <input type="text" class="form-control" id="DiaChi" name="DiaChi" value="<?php echo $employee['DiaChi']; ?>" required>
            </div>
            <div class="form-group">
                <label for="SoDienThoai">Số Điện Thoại</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai" value="<?php echo $employee['SoDienThoai']; ?>" required>
            </div>
            <div class="form-group">
                <label for="SoCCCD">CCCD</label>
                <input type="text" class="form-control" id="SoCCCD" name="SoCCCD" value="<?php echo $employee['SoCCCD']; ?>" required>
            </div>
            <div class="form-group">
                <label for="TrinhDo">Trình Độ</label>
                <input type="text" class="form-control" id="TrinhDo" name="TrinhDo" value="<?php echo $employee['TrinhDo']; ?>" required>
            </div>
            <div class="form-group">
                <label for="ChucVu">Chức Vụ</label>
                <input type="text" class="form-control" id="ChucVu" name="ChucVu" value="<?php echo $employee['ChucVu']; ?>" required>
            </div>
            <div class="form-group">
                <label for="NgayVaoLam">Ngày Vào Làm</label>
                <input type="date" class="form-control" id="NgayVaoLam" name="NgayVaoLam" value="<?php echo $employee['NgayVaoLam']; ?>" required>
            </div>
            <div class="form-group">
                <label for="MucLuong">Lương</label>
                <input type="number" class="form-control" id="MucLuong" name="MucLuong" value="<?php echo $employee['MucLuong']; ?>" required>
            </div>
            <div class="form-group">
                <label for="PhuCap">Phụ Cấp</label>
                <input type="number" class="form-control" id="PhuCap" name="PhuCap" value="<?php echo $employee['PhuCap']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning" name="update">Cập nhật</button>
        </form>
    </div>
</body>
</html>
