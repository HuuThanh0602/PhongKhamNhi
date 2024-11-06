<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// Kết nối cơ sở dữ liệu
require_once '../Database/DBConnection.php';

try {
    $db = new DBConnection();
    $conn = $db->connect();

    $searchQuery = "";
    $params = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
        $maNhanVien = trim($_POST['ma-nhan-vien'] ?? '');
        $hoTen = trim($_POST['ho-ten'] ?? '');
        $thoiGian = trim($_POST['thoi-gian'] ?? '');

        $searchQuery = " WHERE 1=1";
        if (!empty($maNhanVien)) {
            $searchQuery .= " AND ln.MaNhanVien = :maNhanVien";
            $params[':maNhanVien'] = $maNhanVien;
        }
        if (!empty($hoTen)) {
            $searchQuery .= " AND nv.HoTen LIKE :hoTen";
            $params[':hoTen'] = "%$hoTen%";
        }
        if (!empty($thoiGian)) {
            $month = date('m', strtotime($thoiGian));
            $year = date('Y', strtotime($thoiGian));
            $searchQuery .= " AND ln.Thang = :month AND ln.Nam = :year";
            $params[':month'] = $month;
            $params[':year'] = $year;
        }
    }

    $sql = "
        SELECT 
            ln.MaNhanVien, 
            nv.HoTen, 
            ln.Thang, 
            ln.Nam, 
            nv.MucLuong, 
            ln.SoNgayCong, 
            nv.PhuCap,
            (nv.MucLuong * ln.SoNgayCong + nv.PhuCap) AS Tong
        FROM 
            LuongNhanVien ln
        INNER JOIN 
            NhanVien nv ON ln.MaNhanVien = nv.MaNhanVien
        $searchQuery
    ";

    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMessage = "Lỗi kết nối: " . $e->getMessage();
    echo "<script>alert('$errorMessage');</script>";
}

if (isset($_POST['delete'])) {
    $maNhanVienXoa = $_POST['ma-nhan-vien-xoa'];
    $sqlDelete = "DELETE FROM LuongNhanVien WHERE MaNhanVien = :maNhanVien";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bindValue(':maNhanVien', $maNhanVienXoa);
    $stmtDelete->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['edit'])) {
    $maNhanVienSua = $_POST['ma-nhan-vien-sua'];
    $soNgayCong = $_POST['so-ngay-cong-sua'];
    $thangSua = $_POST['thang-sua'];
    $namSua = $_POST['nam-sua'];

    if (is_numeric($soNgayCong) && $soNgayCong >= 0) {
        $sqlUpdate = "UPDATE LuongNhanVien SET SoNgayCong = :soNgayCong WHERE MaNhanVien = :maNhanVien AND Thang = :thang AND Nam = :nam";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindValue(':soNgayCong', $soNgayCong);
        $stmtUpdate->bindValue(':maNhanVien', $maNhanVienSua);
        $stmtUpdate->bindValue(':thang', $thangSua);
        $stmtUpdate->bindValue(':nam', $namSua);

        if ($stmtUpdate->execute()) {
            echo "<script>alert('Cập nhật số ngày công thành công!');</script>";
        } else {
            echo "<script>alert('Lỗi khi cập nhật số ngày công!');</script>";
        }
    } else {
        echo "<script>alert('Số ngày công không hợp lệ!');</script>";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản Lý Lương Nhân Viên</title>

    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
<div class="container-fluid px-4">
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 mb-4 bg-white rounded">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center text-primary" href="../home/home.php">
                    <i class="bi bi-house-door me-2"></i>
                    Trang Chủ
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Quản Lý Nhân Viên</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" href="indexLoaiThuoc.php">Quản Lý Lương</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="account/account_management.php">Quản Lý Tài Khoản</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Search Section -->
    <section class="mb-4 p-4 bg-light rounded shadow-sm">
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <label for="ma-nhan-vien" class="form-label">Mã Nhân Viên</label>
                <input type="text" class="form-control" id="ma-nhan-vien" name="ma-nhan-vien" value="<?= htmlspecialchars($_POST['ma-nhan-vien'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="ho-ten" class="form-label">Họ Tên</label>
                <input type="text" class="form-control" id="ho-ten" name="ho-ten" value="<?= htmlspecialchars($_POST['ho-ten'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="thoi-gian" class="form-label">Thời Gian (tháng/năm)</label>
                <input type="month" class="form-control" id="thoi-gian" name="thoi-gian" value="<?= htmlspecialchars($_POST['thoi-gian'] ?? '') ?>">
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" name="search" class="btn btn-primary"><i class="bi bi-search"></i> Tìm Kiếm</button>
            </div>
        </form>
    </section>
     <!-- Table section -->
     <section>
            <table class="table table-bordered table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>Mã Nhân Viên</th>
                        <th>Họ Tên</th>
                        <th>Thời Gian (tháng/năm)</th>
                        <th>Lương Cơ Bản</th>
                        <th>Số Ngày Công</th>
                        <th>Phụ Cấp</th>
                        <th>Tổng Lương</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['MaNhanVien']) ?></td>
                            <td><?= htmlspecialchars($row['HoTen']) ?></td>
                            <td><?= htmlspecialchars($row['Thang']) . "/" . htmlspecialchars($row['Nam']) ?></td>
                            <td><?= htmlspecialchars($row['MucLuong']) ?></td>
                            <td><?= htmlspecialchars($row['SoNgayCong']) ?></td>
                            <td><?= htmlspecialchars($row['PhuCap']) ?></td>
                            <td><?= htmlspecialchars($row['Tong']) ?></td>
                            <td class="d-flex">
                                <form method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="ma-nhan-vien-sua" value="<?= htmlspecialchars($row['MaNhanVien']) ?>">
                                    <input type="number" style="width:70px" name="so-ngay-cong-sua" value="<?= htmlspecialchars($row['SoNgayCong']) ?>" min="0" required class="form-control me-2">
                                    <input type="hidden" name="thang-sua" value="<?= htmlspecialchars($row['Thang']) ?>">
                                    <input type="hidden" name="nam-sua" value="<?= htmlspecialchars($row['Nam']) ?>">
                                    <button type="submit" name="edit" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil"></i> Sửa</button>
                                </form>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="ma-nhan-vien-xoa" value="<?= htmlspecialchars($row['MaNhanVien']) ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="bi bi-trash"></i> Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>


       

    <!-- Bootstrap JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>