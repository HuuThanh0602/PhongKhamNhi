
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 mb-4 bg-white rounded">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center text-dark" href="../../home/home.php" style="color: black;">
                <i class="bi bi-house-door me-2"></i>
                Trang Chủ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="" style="color: black;"><strong>Quản Lý Nhân Viên</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../QLLuong.php" style="color: black;">Quản Lý Lương</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="../account/account_management.php" style="color: black;">Quản Lý Tài Khoản</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
    <div class="container mt-5">
       

        <form method="GET" action="">
            <input type="text" name="search" class="form-control mb-3" placeholder="Tìm kiếm nhân viên..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <a href="add_employee.php" class="btn btn-primary mb-3">Thêm nhân viên</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>CCCD</th>
                    <th>Trình độ</th>
                    <th>Chức vụ</th>
                    <th>Ngày vào làm</th>
                    <th>Lương</th>
                    <th>Phụ cấp</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../../Database/DBConnection.php';
                $db = new DBConnection();
                $conn = $db->connect();

                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $stmt = $conn->prepare("SELECT * FROM NhanVien WHERE HoTen LIKE :search");
                $stmt->execute(['search' => '%' . $search . '%']);
                $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($employees as $employee) {
                    echo "<tr>
                        <td>{$employee['MaNhanVien']}</td>
                        <td>{$employee['HoTen']}</td>
                        <td>{$employee['NgaySinh']}</td>
                        <td>{$employee['GioiTinh']}</td>
                        <td>{$employee['DiaChi']}</td>
                        <td>{$employee['SoDienThoai']}</td>
                        <td>{$employee['SoCCCD']}</td>
                        <td>{$employee['TrinhDo']}</td>
                        <td>{$employee['ChucVu']}</td>
                        <td>{$employee['NgayVaoLam']}</td>
                        <td>{$employee['MucLuong']}</td>
                        <td>{$employee['PhuCap']}</td>
                        <td>
                            <a href='edit_employee.php?id={$employee['MaNhanVien']}' class='btn btn-warning btn-sm'>Sửa</a>
                            <a href='delete_employee.php?id={$employee['MaNhanVien']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
