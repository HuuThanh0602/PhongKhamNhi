<?php
require_once '../Database/DBConnection.php';

try {
    $db = new DBConnection();
    $conn = $db->connect();
    $sql = "SELECT TOP 500 * FROM ThongTinBenhNhanXetNghiemDonThuoc";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thông Tin Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thông Tin Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .header-container {
            background-color: #f8f9fa; 
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }
     
        .navbar-nav .nav-link {
            font-size: 1rem;
            font-weight: 500;
            color: #6c757d; 
        }
    </style>
</head>
<body>

    <!-- Header Container -->
    <div class="container my-4 header-container">
        <header class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand d-flex align-items-center text-primary" href="../home/home.php">
                <i class="bi bi-house-door me-2"></i> Trang Chủ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="ThongKe.php">
                            <i class="bi bi-arrow-left me-2"></i> Quay lại
                        </a>
                    </li>
                </ul>
            </div>
        </header>
    </div>

    <!-- Title Section -->
    <div class="container my-5 title-section">
        <h2 class="text-center text-primary fw-bold">Quản Lý Thông Tin Bệnh Nhân</h2>
    </div>
</body>
</html>

    <!-- Table Section -->
    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Mã Bệnh Nhân</th>
                        <th>Tên Bệnh Nhân</th>
                        <th>Giới Tính</th>
                        <th>Địa Chỉ</th>
                        <th>Mã Phiếu Xét Nghiệm</th>
                        <th>Tên Xét Nghiệm</th>
                        <th>Kết Quả Xét Nghiệm</th>
                        <th>Mã Đơn</th>
                        <th>Mã Thuốc</th>
                        <th>Tên Thuốc</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)): ?>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['MaBenhNhan']) ?></td>
                                <td><?= htmlspecialchars($row['TenBenhNhan']) ?></td>
                                <td><?= htmlspecialchars($row['GioiTinh']) ?></td>
                                <td><?= htmlspecialchars($row['DiaChi']) ?></td>
                                <td><?= htmlspecialchars($row['MaPhieuXetNghiem']) ?></td>
                                <td><?= htmlspecialchars($row['TenXetNghiem']) ?></td>
                                <td><?= htmlspecialchars($row['KetQuaXetNghiem']) ?></td>
                                <td><?= htmlspecialchars($row['MaDon']) ?></td>
                                <td><?= htmlspecialchars($row['MaThuoc']) ?></td>
                                <td><?= htmlspecialchars($row['TenThuoc']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-auto py-3">
        <div class="container text-center">
            <p class="text-muted mb-0">© 2023 Quản Lý Thông Tin Bệnh Nhân</p>
        </div>
    </footer>

    <!-- Bootstrap JS from CDN -->
    <<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>

</body>
</html>
