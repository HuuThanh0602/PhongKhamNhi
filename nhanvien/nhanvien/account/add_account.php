<?php
require_once '../DBConnection.php';

// Kết nối đến cơ sở dữ liệu
$db = new DBConnection();
$conn = $db->connect();

// Lấy danh sách ID và tên nhân viên từ bảng NhanVien
$stmt = $conn->query("SELECT MaNhanVien, HoTen FROM NhanVien");
$nhan_vien = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $so_tai_khoan = $_POST['so_tai_khoan'];
    $ma_nhan_vien = $_POST['ma_nhan_vien'];
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau']; // Không mã hóa mật khẩu

    // Kiểm tra nếu ID nhân viên tồn tại trong bảng NhanVien
    $checkStmt = $conn->prepare("SELECT MaNhanVien FROM NhanVien WHERE MaNhanVien = :ma_nhan_vien");
    $checkStmt->bindParam(':ma_nhan_vien', $ma_nhan_vien);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        // Kiểm tra nếu SoTaiKhoan, Tên đăng nhập hoặc MaNhanVien đã tồn tại trong bảng TaiKhoan
        $checkUsernameStmt = $conn->prepare("SELECT SoTaiKhoan, TenDangNhap FROM TaiKhoan WHERE SoTaiKhoan = :so_tai_khoan OR TenDangNhap = :ten_dang_nhap OR MaNhanVien = :ma_nhan_vien");
        $checkUsernameStmt->bindParam(':so_tai_khoan', $so_tai_khoan);
        $checkUsernameStmt->bindParam(':ten_dang_nhap', $ten_dang_nhap);
        $checkUsernameStmt->bindParam(':ma_nhan_vien', $ma_nhan_vien);
        $checkUsernameStmt->execute();

        if ($checkUsernameStmt->rowCount() > 0) {
            $message = "Số tài khoản, tên đăng nhập hoặc ID nhân viên đã tồn tại. Vui lòng chọn giá trị khác.";
        } else {
            // Chèn dữ liệu vào bảng TaiKhoan mà không mã hóa mật khẩu
            $stmt = $conn->prepare("INSERT INTO TaiKhoan (SoTaiKhoan, MaNhanVien, TenDangNhap, MatKhau) VALUES (:so_tai_khoan, :ma_nhan_vien, :ten_dang_nhap, :mat_khau)");
            $stmt->bindParam(':so_tai_khoan', $so_tai_khoan);
            $stmt->bindParam(':ma_nhan_vien', $ma_nhan_vien);
            $stmt->bindParam(':ten_dang_nhap', $ten_dang_nhap);
            $stmt->bindParam(':mat_khau', $mat_khau); // Lưu mật khẩu ở dạng văn bản rõ ràng

            if ($stmt->execute()) {
                // Chuyển hướng về trang quản lý tài khoản nếu thêm thành công
                header("Location: account_management.php");
                exit();
            } else {
                $message = "Có lỗi xảy ra khi thêm tài khoản. Vui lòng thử lại.";
            }
        }
    } else {
        $message = "ID nhân viên không tồn tại.";
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Thêm tài khoản</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="so_tai_khoan">Số tài khoản</label>
                <input type="text" name="so_tai_khoan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="ma_nhan_vien">ID Nhân viên</label>
                <select name="ma_nhan_vien" class="form-control" required>
                    <option value="">Chọn nhân viên...</option>
                    <?php foreach ($nhan_vien as $nv): ?>
                        <option value="<?php echo htmlspecialchars($nv['MaNhanVien']); ?>">
                            <?php echo htmlspecialchars($nv['MaNhanVien']) . " - " . htmlspecialchars($nv['HoTen']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ten_dang_nhap">Tên đăng nhập</label>
                <input type="text" name="ten_dang_nhap" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mat_khau">Mật khẩu</label>
                <input type="text" name="mat_khau" class="form-control" required> <!-- Đã sửa để hiển thị mật khẩu dưới dạng văn bản -->
            </div>
            <button type="submit" class="btn btn-success">Thêm tài khoản</button>
            <a href="account_management.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</body>
</html>
