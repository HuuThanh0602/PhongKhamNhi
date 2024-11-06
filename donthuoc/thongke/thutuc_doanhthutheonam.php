<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tính Doanh Thu Năm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
        <h2 class="text-center text-primary fw-bold">Tính Doanh Thu Năm</h2>
    </div>

<div class="container">
    <!-- Form nhập năm -->
    <form method="POST" action="" class="mt-4">
        <div class="form-group">
            <label for="nam">Nhập năm:</label>
            <input type="number" id="nam" name="nam" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tính Doanh Thu</button>
    </form>

    <?php
    require_once '../Database/DBConnection.php';

    // Kiểm tra nếu đã gửi năm từ form
    if (isset($_POST['nam'])) {
        $nam = $_POST['nam'];

        try {
            // Tạo đối tượng kết nối từ DBConnection
            $db = new DBConnection();
            $conn = $db->connect();

            // Truy vấn gọi thủ tục DOANHTHUNAM để tính doanh thu cho năm đã chọn
            $sql = "EXEC DOANHTHUNAM :nam";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nam', $nam, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra và hiển thị kết quả dưới dạng bảng HTML
            if ($result && $result['DoanhThu'] !== null) {
                echo "<br> <div class='table-container'>
                        <table class='table table-bordered table-striped'>
                            <thead class='thead-light'>
                                <tr>
                                    <th>Năm</th>
                                    <th>Doanh Thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>" . htmlspecialchars($result['Nam']) . "</td>
                                    <td>" . number_format($result['DoanhThu'], 0, ',', '.') . " VND</td>
                                </tr>
                            </tbody>
                        </table>
                      </div>";
            } else {
                echo "<br> <p class='alert alert-warning'>Không có dữ liệu doanh thu cho năm " . htmlspecialchars($nam) . "</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='alert alert-danger'>Lỗi kết nối: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Vui lòng nhập năm và thử lại.</p>";
    }
    ?>
</div>

<!-- Thêm liên kết tới Bootstrap JS và jQuery -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>