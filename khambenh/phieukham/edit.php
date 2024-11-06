<?php
session_start();
require_once '../../Database/DBConnection.php';

// Kiểm tra nếu có id trong URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kết nối cơ sở dữ liệu
    $db = new DBConnection();
    $conn = $db->connect();

    // Lấy thông tin phiếu khám từ cơ sở dữ liệu
    $query = "SELECT * FROM PhieuKham WHERE MaPhieuKham = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $phieuKham = $stmt->fetch();

    // Nếu không tìm thấy phiếu khám
    if (!$phieuKham) {
        $_SESSION['message'] = 'Không tìm thấy phiếu khám!';
        header('Location: index.php');
        exit();
    }

    // Nếu có POST dữ liệu (cập nhật thông tin)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lyDoKhamBenh = $_POST['lyDoKhamBenh'];
        $chuanDoan = $_POST['chuanDoan'];
        $ketLuan = $_POST['ketLuan'];

        // Cập nhật thông tin phiếu khám
        $updateQuery = "UPDATE PhieuKham SET LyDoKhamBenh = :lyDoKhamBenh, ChuanDoan = :chuanDoan, KetLuan = :ketLuan WHERE MaPhieuKham = :id";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':lyDoKhamBenh', $lyDoKhamBenh, PDO::PARAM_STR);
        $updateStmt->bindParam(':chuanDoan', $chuanDoan, PDO::PARAM_STR);
        $updateStmt->bindParam(':ketLuan', $ketLuan, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($updateStmt->execute()) {
            $_SESSION['message'] = 'Cập nhật phiếu khám thành công!';
            header('Location: phieukham.php');
            exit();
        } else {
            $_SESSION['message'] = 'Lỗi khi cập nhật phiếu khám!';
        }
    }
} else {
    // Nếu không có id, chuyển hướng về trang danh sách
    header('Location: phieukham.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Phiếu Khám</title>
    <link rel="stylesheet" href="../../accset/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Sửa Phiếu Khám</h2>

    <!-- Hiển thị thông báo -->
    <?php
    if (isset($_SESSION['message'])) {
        echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <!-- Form sửa phiếu khám -->
    <form action="" method="post">
        <div class="form-group">
            <label for="lyDoKhamBenh">Lý Do Khám</label>
            <input type="text" class="form-control" id="lyDoKhamBenh" name="lyDoKhamBenh" value="<?= htmlspecialchars($phieuKham['LyDoKhamBenh']); ?>" required>
        </div>
        <div class="form-group">
            <label for="chuanDoan">Chuẩn Đoán</label>
            <input type="text" class="form-control" id="chuanDoan" name="chuanDoan" value="<?= htmlspecialchars($phieuKham['ChuanDoan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="ketLuan">Kết Luận</label>
            <input type="text" class="form-control" id="ketLuan" name="ketLuan" value="<?= htmlspecialchars($phieuKham['KetLuan']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
    </form>
</div>

</body>
</html>
