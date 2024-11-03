<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee & Account Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4"> Quản lý nhân viên & tài khoản  </h2>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="employee-tab" data-toggle="tab" href="#employee" role="tab">nhân viên</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab"> tài khoản</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content mt-3">
            <!-- Employee List -->
            <div class="tab-pane fade show active" id="employee" role="tabpanel">
                <h3>Danh sách nhân viên</h3>
                <form method="GET" action="">
                    <input type="text" name="search" class="form-control mb-3" placeholder="Search Employees..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </form>
                <a href="add_employee.php" class="btn btn-primary mb-3">Thêm nhân viên</a>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>CCCD</th>
                            <th>Education</th>
                            <th>Position</th>
                            <th>Start Date</th>
                            <th>Salary</th>
                            <th>Allowance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Connect to SQL Server and fetch employee data
                        require_once 'DBConnection.php';
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
                                    <a href='edit_employee.php?id={$employee['MaNhanVien']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_employee.php?id={$employee['MaNhanVien']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Account List -->
            <div class="tab-pane fade" id="account" role="tabpanel">
                <h3>Account List</h3>
                <form method="GET" action="">
                    <input type="text" name="search_account" class="form-control mb-3" placeholder="Search by Employee ID..." value="<?php echo isset($_GET['search_account']) ? htmlspecialchars($_GET['search_account']) : ''; ?>">
                </form>
                <a href="add_account.php" class="btn btn-primary mb-3">Add New Account</a>
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Account Number</th>
                            <th>Employee ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch account data
                        $search_account = isset($_GET['search_account']) ? $_GET['search_account'] : '';
                        $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE MaNhanVien LIKE :search_account");
                        $stmt->execute(['search_account' => '%' . $search_account . '%']);
                        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($accounts as $account) {
                            echo "<tr>
                    <td>{$account['SoTaiKhoan']}</td>
                    <td>{$account['MaNhanVien']}</td>
                    <td>{$account['TenDangNhap']}</td>
                    <td>{$account['MatKhau']}</td>
                    <td>
                        <a href='edit_account.php?id={$account['SoTaiKhoan']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='delete_account.php?id={$account['SoTaiKhoan']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Bootstrap JS and dependencies -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>