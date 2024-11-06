<?php
session_start();
require_once '../Database/DBConnection.php';

// Get MaXetNghiem from the URL to load the data
if (isset($_GET['id'])) {
    $maXetNghiem = $_GET['id'];

    // Connect to the database
    $db = new DBConnection();
    $conn = $db->connect();

    // Fetch existing data
    $stmt = $conn->prepare("SELECT * FROM DanhMucXetNghiem WHERE MaXetNghiem = :maXetNghiem");
    $stmt->execute(['maXetNghiem' => $maXetNghiem]);
    $test = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$test) {
        echo "<script>alert('Xét nghiệm không tồn tại!'); window.location='index.php';</script>";
        exit;
    }
}

// Handle form submission to update the record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the updated data from the form
    $tenXetNghiem = $_POST['tenXetNghiem'];
    $donGia = $_POST['donGia'];

    // Update the record in the database
    $stmt = $conn->prepare("UPDATE DanhMucXetNghiem SET TenXetNghiem = :tenXetNghiem, DonGia = :donGia WHERE MaXetNghiem = :maXetNghiem");
    $stmt->execute([
        'tenXetNghiem' => $tenXetNghiem,
        'donGia' => $donGia,
        'maXetNghiem' => $maXetNghiem
    ]);

    echo "<script>alert('Cập nhật thành công!'); window.location='DanhMucKham.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cập Nhật Danh Mục Xét Nghiệm</title>
    <link rel="stylesheet" href="../accset/css/bootstrap.min.css">
    <script src="../accset/js/jquery-3.5.1.min.js"></script>
    <script src="../accset/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container .form-group {
            margin-bottom: 20px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <!-- Navbar omitted for brevity -->
</header>

<div class="form-container">
    <form action="edit.php?id=<?php echo $maXetNghiem; ?>" method="post">
        <div class="form-group">
            <label for="tenXetNghiem">Tên Xét Nghiệm:</label>
            <input type="text" id="tenXetNghiem" name="tenXetNghiem" class="form-control" 
                   value="<?php echo htmlspecialchars($test['TenXetNghiem']); ?>" required>
        </div>
        <div class="form-group">
            <label for="donGia">Đơn Giá:</label>
            <input type="number" id="donGia" name="donGia" class="form-control" 
                   value="" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

</body>
</html>
