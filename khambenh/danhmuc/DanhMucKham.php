<?php
session_start();  // Always start the session at the very top
require_once '../../Database/DBConnection.php';
// Display session message if exists
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Handle form submission for adding a new record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maXetNghiem = $_POST['maXetNghiem'];
    $tenXetNghiem = $_POST['tenXetNghiem'];
    $donGia = $_POST['donGia'];


    $db = new DBConnection();
    $conn = $db->connect();

    try {
        // Check if the MaXetNghiem already exists to avoid duplicates
        $stmt = $conn->prepare("SELECT COUNT(*) FROM DanhMucXetNghiem WHERE MaXetNghiem = :maXetNghiem");
        $stmt->execute(['maXetNghiem' => $maXetNghiem]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            echo "<script>alert('Mã Xét Nghiệm đã tồn tại!');</script>";
        } else {
            // Insert the new record
            $stmt = $conn->prepare("INSERT INTO DanhMucXetNghiem (MaXetNghiem, TenXetNghiem, DonGia) VALUES (:maXetNghiem, :tenXetNghiem, :donGia)");
            $stmt->execute([
                'maXetNghiem' => $maXetNghiem,
                'tenXetNghiem' => $tenXetNghiem,
                'donGia' => $donGia
            ]);
            $_SESSION['message'] = 'Thêm thành công!';
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to the same page to prevent resubmission
            exit();
        }
    } catch (PDOException $e) {
        echo "<script>alert('Lỗi: " . $e->getMessage() . "');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quản Lý Danh Mục Xét Nghiệm</title>
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
        .buttons { display: flex; justify-content: space-between; align-items: center; margin-left: 30px; }
        .btn-primary { background-color: #007bff; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; transition: background-color 0.3s; }
        .btn-primary:hover { background-color: #0056b3; color: white; }
        table.table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        table.table th, table.table td { padding: 15px; border: 1px solid #e9e9e9; }
        table.table th { background: #f8f8f8; text-align: left; }
        td a { margin-right: 5px; display: inline-block; text-align: center; }
        i { font-size: 22px; }
        .delete-icon { color: #F44336; }
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
                    <li class="nav-item"><a class="nav-link" href="../phieukham/phieukham.php">Phiếu Khám</a></li>
                    <li class="nav-item"><a class="nav-link active " href=""><strong>Danh Mục Xét Nghiệm</strong></a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="table-wrapper">
    <div class="table-title">
        <h2>Quản Lý <b>Danh Mục Xét Nghiệm</b></h2>
    </div>
    <div class="form-container">
        <div class="buttons">
            <form action="" method="post" class="d-flex">
                <div class="form-group">
                    <label for="maXetNghiem">Mã Xét Nghiệm:</label>
                    <input type="text" id="maXetNghiem" name="maXetNghiem" class="form-control" required>
                </div>
                <div class="form-group" style="margin-left:25px">
                    <label for="tenXetNghiem">Tên Xét Nghiệm:</label>
                    <input type="text" id="tenXetNghiem" name="tenXetNghiem" class="form-control" required>
                </div>
                <div class="form-group" style="margin-left:25px">
                    <label for="donGia">Đơn Giá:</label>
                    <input type="number" id="donGia" name="donGia" class="form-control" required>
                </div>
                <button type="submit" style="height:40px;margin:25px" class="btn btn-primary">Thêm</button>
            </form>
            <div class="search">
                <form method="get" action="" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Nhập tên xét nghiệm..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
            </div>
        </div>
    </div>

    <?php

    $db = new DBConnection();
    $conn = $db->connect();

    // Prepare SQL query to fetch records, search by `TenXetNghiem`
    $stmt = $conn->prepare("SELECT * FROM DanhMucXetNghiem WHERE TenXetNghiem LIKE :search");
    $stmt->execute(['search' => '%' . $search . '%']);
    $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã Xét Nghiệm</th>
                <th>Tên Xét Nghiệm</th>
                <th>Đơn Giá</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tests as $index => $test): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($test['MaXetNghiem']) ?></td>
                <td><?= htmlspecialchars($test['TenXetNghiem']) ?></td>
                <td><?= number_format($test['DonGia']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $test['MaXetNghiem'] ?>" class="edit-icon"><i class="bi bi-pencil"></i></a>
                    <a href="delete.php?id=<?= $test['MaXetNghiem'] ?>" class="delete-icon"><i class="bi bi-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
