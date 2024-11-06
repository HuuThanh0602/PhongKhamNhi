<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Bệnh Nhân</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            margin-bottom: 30px;
        }

        .navbar .title {
            font-size: 24px;
            font-weight: bold;
        }

        table {
            margin-top: 20px;
        }

        th, td {
            text-align: center;
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-brand">Quản Lý Bệnh Nhân</div>
        <div><a href="../ThongKe.php" class="text-white">Quay Lại</a></div>
    </div>
</nav>

<div class="container">
    <!-- Form nhập mã phiếu khám -->
    <form method="GET" class="form-inline mb-3">
        <input type="text" class="form-control mr-2" name="ma_phieu_kham" placeholder="Nhập mã phiếu khám" value="<?php echo isset($_GET['ma_phieu_kham']) ? htmlspecialchars($_GET['ma_phieu_kham']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Tính Tổng Chi Phí</button>
    </form>

    <?php
    require_once '../../Database/DBConnection.php';

    try {
        // Tạo đối tượng kết nối
        $db = new DBConnection();
        $conn = $db->connect();

        // Lấy mã phiếu khám từ form (nếu có)
        $maPhieuKham = isset($_GET['ma_phieu_kham']) ? $_GET['ma_phieu_kham'] : '';

        if ($maPhieuKham) {
            // Khai báo câu lệnh SQL để thực thi thủ tục
            $sql = "DECLARE @TongChiPhi MONEY;
                    EXEC TinhTongChiPhiPhieuKham :maPhieuKham, @TongChiPhi OUTPUT;
                    SELECT @TongChiPhi AS TongChiPhi;";
            
            // Chuẩn bị và thực thi câu lệnh SQL
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':maPhieuKham', $maPhieuKham);
            $stmt->execute();

            // Lấy kết quả từ câu lệnh SELECT cuối cùng
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra và hiển thị tổng chi phí
            if ($result) {
                // Nếu TongChiPhi là null, gán giá trị mặc định là 0
                $tongChiPhi = $result['TongChiPhi'] ?? 0;
                echo "<div class='alert alert-success' role='alert'>Tổng chi phí cho phiếu khám <strong>$maPhieuKham</strong> là: " . number_format($tongChiPhi, 2) . " VND</div>";
            } else {
                echo "<div class='alert alert-warning' role='alert'>Không tìm thấy phiếu khám với mã này.</div>";
            }
        }

    } catch (Exception $e) {
        echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $e->getMessage() . "</div>";
    }
?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
