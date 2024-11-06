<?php
session_start();
require_once '../../Database/DBConnection.php';

// Ensure DBConnection is correctly instantiated
$db = new DBConnection();
$conn = $db->connect();  // Initialize the connection here

// Display session message if exists
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';  // Trim to avoid leading/trailing spaces

if ($search !== '') {
    $searchValue = "%" . $search . "%";

    // Truy vấn với INNER JOIN để lấy tên bệnh nhân và tên nhân viên
    $query = "
        SELECT PhieuKham.MaPhieuKham, 
               BenhNhan.TenBenhNhan, 
               NhanVien.HoTen AS TenNhanVien,  -- Correcting this to 'HoTen' as the doctor's name
               PhieuKham.LyDoKhamBenh, 
               PhieuKham.ChuanDoan, 
               PhieuKham.NgayLamPhieu, 
               PhieuKham.KetLuan 
        FROM PhieuKham 
        INNER JOIN BenhNhan ON PhieuKham.MaBenhNhan = BenhNhan.MaBenhNhan 
        INNER JOIN NhanVien ON PhieuKham.MaNhanVien = NhanVien.MaNhanVien
        WHERE BenhNhan.TenBenhNhan LIKE ? OR BenhNhan.MaBenhNhan LIKE ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $searchValue, PDO::PARAM_STR);
    $stmt->bindParam(2, $searchValue, PDO::PARAM_STR);
    $stmt->execute();
} else {
    // Truy vấn mặc định khi không có tìm kiếm
    $query = "
        SELECT PhieuKham.MaPhieuKham, 
               BenhNhan.TenBenhNhan, 
               NhanVien.HoTen AS TenNhanVien,  -- Correcting this to 'HoTen' as the doctor's name
               PhieuKham.LyDoKhamBenh, 
               PhieuKham.ChuanDoan, 
               PhieuKham.NgayLamPhieu, 
               PhieuKham.KetLuan 
        FROM PhieuKham 
        INNER JOIN BenhNhan ON PhieuKham.MaBenhNhan = BenhNhan.MaBenhNhan 
        INNER JOIN NhanVien ON PhieuKham.MaNhanVien = NhanVien.MaNhanVien
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
}

$phieuKham = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản Lý Phiếu Khám</title>
    <link rel="stylesheet" href="../../accset/css/bootstrap.min.css">
    <link href="../../accset/css/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet"> 
    <script src="../../accset/js/jquery-3.5.1.min.js"></script>
    <script src="../../accset/js/popper.min.js"></script>
    <script src="../../accset/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Custom Styles */
        body {
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
            font-size: 13px;
            margin: 0;
        }
        .navbar { background: #435d7d; font-size: 18px; }
        .navbar .nav-link { color: white; }
        .navbar .nav-link:hover { color: white; }
        .table-wrapper { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .table-title h2 { margin: 10px; font-size: 30px; text-align: center; }
        .form-container { background: #f9f9f8; padding: 20px; border-radius: 5px; margin: 15px 0; box-shadow: 4px 3px 8px rgba(0, 0, 0, 0.4); }
        .form-group { margin-bottom: 15px; }
        .btn-primary { background-color: #007bff; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; transition: background-color 0.3s; }
        .btn-primary:hover { background-color: #0056b3; color: white; }
        table.table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        table.table th, table.table td { padding: 15px; border: 1px solid #e9e9e9; }
        table.table th { background: #f8f8f8; text-align: left; }
        td a { margin-right: 5px; display: inline-block; text-align: center; }
        i { font-size: 22px; }
        .edit-icon { color: #FFC107; }
    </style>
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg shadow p-3">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="../../home/home.php">Trang ngoài</a></li>
                    <li class="nav-item"><a class="nav-link" href="../benhnhan/benhnhan.php">Bệnh Nhân</a></li>
                    <li class="nav-item"><a class="nav-link active" href=""><strong>Phiếu Khám</strong></a></li>
                    <li class="nav-item"><a class="nav-link" href="../danhmuc/DanhMucKham.php">Danh Mục Xét Nghiệm</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="table-wrapper">
    <div class="table-title">
        <h2>Quản Lý <b>Phiếu Khám</b></h2>
    </div>

    <!-- Search -->
    <form action="" method="get" class="form-inline mb-3">
        <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($search); ?>" placeholder="Tìm kiếm phiếu khám...">
        <button type="submit" class="btn-primary">Tìm kiếm</button>
    </form>
    <a href="add.php" class="btn-primary">Thêm Phiếu Khám</a>

    <!-- Table to display Phiếu Khám -->
    <table class="table">
    <thead>
        <tr>
            <th>Mã Phiếu Khám</th>
            <th>Tên Bệnh Nhân</th>
            <th>Tên Nhân Viên</th>
            <th>Lý Do Khám</th>
            <th>Chuẩn Đoán</th>
            <th>Ngày Làm Phiếu</th>
            <th>Kết Luận</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($phieuKham as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['MaPhieuKham']); ?></td>
                <td><?= htmlspecialchars($item['TenBenhNhan']); ?></td>
                <td><?= htmlspecialchars($item['TenNhanVien']); ?></td>
                <td><?= htmlspecialchars($item['LyDoKhamBenh']); ?></td>
                <td><?= htmlspecialchars($item['ChuanDoan']); ?></td>
                <td><?= htmlspecialchars($item['NgayLamPhieu']); ?></td>
                <td><?= htmlspecialchars($item['KetLuan']); ?></td>
                <td class="d-flex">
                    <a href="edit.php?id=<?= $item['MaPhieuKham']; ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Sửa
                    </a>
                    <a href="delete.php?id=<?= $item['MaPhieuKham']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn chắc chắn muốn xóa?');">
                        <i class="bi bi-trash"></i> Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

</body>
</html>
