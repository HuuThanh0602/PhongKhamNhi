<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
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
                        <a class="nav-link" href="../employee/employee_management.php" style="color: black;">Quản Lý Nhân Viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../QLLuong.php" style="color: black;">Quản Lý Lương</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="" style="color: black;"><strong>Quản Lý Tài Khoản</strong></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

    <div class="container mt-5">
       

        <!-- Form tìm kiếm tài khoản -->
        <form method="GET" action="">
            <input type="text" name="search_account" class="form-control mb-3" placeholder="Tìm kiếm theo ID nhân viên..."
                value="<?php echo isset($_GET['search_account']) ? htmlspecialchars($_GET['search_account']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <!-- Nút thêm tài khoản -->
        <a href="add_account.php" class="btn btn-success mb-3">Thêm tài khoản</a>

        <!-- Bảng hiển thị danh sách tài khoản -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Số tài khoản</th>
                    <th>ID nhân viên</th>
                    <th>Tên đăng nhập</th>
                    <th>Mật khẩu</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../../Database/DBConnection.php';
                $db = new DBConnection();
                $conn = $db->connect();

                // Kiểm tra xem có yêu cầu tìm kiếm hay không
                $search_account = isset($_GET['search_account']) ? $_GET['search_account'] : '';

                // Sử dụng câu truy vấn có tham số
                $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE MaNhanVien LIKE :search_account");
                $stmt->bindValue(':search_account', '%' . $search_account . '%', PDO::PARAM_STR);
                $stmt->execute();

                $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Hiển thị kết quả
                if (count($accounts) > 0) {
                    foreach ($accounts as $account) {
                        echo "<tr>
                <td>" . htmlspecialchars($account['SoTaiKhoan']) . "</td>
                <td>" . htmlspecialchars($account['MaNhanVien']) . "</td>
                <td>" . htmlspecialchars($account['TenDangNhap']) . "</td>
                <td>" . $account['MatKhau'] . "</td> 
                <td>
                    <a href='edit_account.php?id=" . urlencode($account['SoTaiKhoan']) . "' class='btn btn-warning btn-sm'>Sửa</a>
                    <a href='delete_account.php?id=" . urlencode($account['SoTaiKhoan']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa?\")'>Xóa</a>
                </td>
            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Không tìm thấy tài khoản nào.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS và các phụ thuộc -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>