<?php
require_once '../DBConnection.php';

// Kết nối đến cơ sở dữ liệu
$db = new DBConnection();
$conn = $db->connect();

// Kiểm tra nếu có ID tài khoản
if (isset($_GET['id'])) {
    $so_tai_khoan = $_GET['id'];

    // Lấy thông tin tài khoản theo Số tài khoản
    $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE SoTaiKhoan = :so_tai_khoan");
    $stmt->bindParam(':so_tai_khoan', $so_tai_khoan);
    $stmt->execute();
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra nếu tài khoản không tồn tại
    if (!$account) {
        echo "Tài khoản không tồn tại!";
        exit;
    }
} else {
    echo "Không tìm thấy ID tài khoản!";
    exit;
}

// Kiểm tra nếu form đã được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ma_nhan_vien = $_POST['ma_nhan_vien'];
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau'];

    // Mã hóa mật khẩu nếu có thay đổi
    $hashed_password = password_hash($mat_khau, PASSWORD_BCRYPT);

    // Cập nhật thông tin tài khoản
    $updateStmt = $conn->prepare("UPDATE TaiKhoan SET MaNhanVien = :ma_nhan_vien, TenDangNhap = :ten_dang_nhap, MatKhau = :mat_khau WHERE SoTaiKhoan = :so_tai_khoan");
    $updateStmt->bindParam(':ma_nhan_vien', $ma_nhan_vien);
    $updateStmt->bindParam(':ten_dang_nhap', $ten_dang_nhap);
    $updateStmt->bindParam(':mat_khau', $hashed_password);
    $updateStmt->bindParam(':so_tai_khoan', $so_tai_khoan);

    if ($updateStmt->execute()) {
        header("Location: account_management.php");
        exit();
    } else {
        $message = "Có lỗi xảy ra khi cập nhật tài khoản. Vui lòng thử lại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa tài khoản</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Sửa tài khoản</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="ma_nhan_vien">ID Nhân viên</label>
                <input type="text" name="ma_nhan_vien" class="form-control" value="<?php echo htmlspecialchars($account['MaNhanVien']); ?>" required>
            </div>
            <div class="form-group">
                <label for="ten_dang_nhap">Tên đăng nhập</label>
                <input type="text" name="ten_dang_nhap" class="form-control" value="<?php echo htmlspecialchars($account['TenDangNhap']); ?>" required>
            </div>
            <div class="form-group">
                <label for="mat_khau">Mật khẩu mới</label>
                <input type="password" name="mat_khau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="account_management.php" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <!-- Bootstrap JS và các phụ thuộc -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
