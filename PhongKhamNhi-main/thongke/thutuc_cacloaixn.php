<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Xét Nghiệm</title>
    
    <!-- Bootstrap CSS from CDN -->
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
        <h2 class="text-center text-primary fw-bold">Thông Tin Xét Nghiệm</h2>
    </div>

<!-- Table Section -->
<div class="container mt-4">
    <?php
    require_once '../Database/DBConnection.php';

    try {
        // Kết nối tới cơ sở dữ liệu
        $db = new DBConnection();
        $conn = $db->connect();

        // Gọi thủ tục ThongTinXetNghiem
        $sql = "EXEC ThongTinXetNghiem";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Lấy kết quả
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Kiểm tra và hiển thị kết quả dưới dạng bảng HTML
        if ($results) {
            echo "<div class='table-responsive'>";
            echo "<table class='table table-bordered table-striped'>";
            echo "<thead class='table-primary'>
                    <tr>
                        <th>Mã Xét Nghiệm</th>
                        <th>Tên Xét Nghiệm</th>
                        <th>Số Lần Xét Nghiệm</th>
                    </tr>
                  </thead>
                  <tbody>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['MaXetNghiem']) . "</td>
                        <td>" . htmlspecialchars($row['TenXetNghiem']) . "</td>
                        <td>" . htmlspecialchars($row['SoLanXetNghiem']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
            echo "</div>";
        } else {
            echo "<p class='text-center'>Không có dữ liệu nào được tìm thấy.</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='text-center text-danger'>Lỗi kết nối: " . $e->getMessage() . "</p>";
    }
    ?>
</div>



<!-- Bootstrap JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
