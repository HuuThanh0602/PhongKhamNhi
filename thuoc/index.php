<?php
include '../Database/DBConnection.php';

$searchConditions = [];
$searchParams = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tìm kiếm thuốc
    if (!empty($_POST['MaThuoc'])) {
        $searchConditions[] = "Thuoc.MaThuoc = :MaThuoc";
        $searchParams[':MaThuoc'] = $_POST['MaThuoc'];
    }
    if (!empty($_POST['TenLoaiThuoc'])) {
        $searchConditions[] = "LoaiThuoc.TenLoaiThuoc LIKE :TenLoaiThuoc";
        $searchParams[':TenLoaiThuoc'] = "%" . $_POST['TenLoaiThuoc'] . "%";
    }
    if (!empty($_POST['TenNCC'])) {
        $searchConditions[] = "NhaCungCap.TenNCC LIKE :TenNCC";
        $searchParams[':TenNCC'] = "%" . $_POST['TenNCC'] . "%";
    }

    try {
        $db = new DBConnection();
        $pdo = $db->connect();

        if ($pdo) {
            $sql = "SELECT Thuoc.MaThuoc, Thuoc.TenThuoc, LoaiThuoc.TenLoaiThuoc, NhaCungCap.TenNCC, Thuoc.GiaThuoc, Thuoc.SoLuongThuocTrongKho 
                    FROM Thuoc
                    INNER JOIN LoaiThuoc ON Thuoc.MaLoaiThuoc = LoaiThuoc.MaLoaiThuoc
                    INNER JOIN NhaCungCap ON Thuoc.MaNCC = NhaCungCap.MaNCC";

            if (!empty($searchConditions)) {
                $sql .= " WHERE " . implode(" AND ", $searchConditions);
            }

            $stmt = $pdo->prepare($sql);
            foreach ($searchParams as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            $stmt->execute();
            $thuocData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Không thể kết nối đến cơ sở dữ liệu.");
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    // Lấy tất cả dữ liệu thuốc khi không tìm kiếm
    try {
        $db = new DBConnection();
        $pdo = $db->connect();

        $sql = "SELECT Thuoc.MaThuoc, Thuoc.TenThuoc, LoaiThuoc.TenLoaiThuoc, NhaCungCap.TenNCC, Thuoc.GiaThuoc, Thuoc.SoLuongThuocTrongKho 
                FROM Thuoc
                INNER JOIN LoaiThuoc ON Thuoc.MaLoaiThuoc = LoaiThuoc.MaLoaiThuoc
                INNER JOIN NhaCungCap ON Thuoc.MaNCC = NhaCungCap.MaNCC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $thuocData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

// Xử lí xoá



?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thuốc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../home/home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" href="../thuoc/index.php">Thuốc</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="my-4">
        <div class="container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Quản lý thuốc</h1>
                <a href="addThuoc.php" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm thuốc</a>
            </div>

            <!-- Form Tìm kiếm -->
            <form method="POST" action="" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="MaThuoc" class="form-label">Mã thuốc</label>
                        <input type="text" id="MaThuoc" name="MaThuoc" class="form-control" placeholder="Mã thuốc">
                    </div>
                    <div class="col-md-4">
                        <label for="TenLoaiThuoc" class="form-label">Tên loại thuốc</label>
                        <input type="text" id="TenLoaiThuoc" name="TenLoaiThuoc" class="form-control" placeholder="Tên loại thuốc">
                    </div>
                    <div class="col-md-4">
                        <label for="TenNCC" class="form-label">Nhà cung cấp</label>
                        <input type="text" id="TenNCC" name="TenNCC" class="form-control" placeholder="Nhà cung cấp">
                    </div>
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>
                </div>
            </form>

            <!-- Bảng dữ liệu -->
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã thuốc</th>
                            <th scope="col">Tên thuốc</th>
                            <th scope="col">Tên loại thuốc</th>
                            <th scope="col">Tên nhà cung cấp</th>
                            <th scope="col">Giá thuốc</th>
                            <th scope="col">Số lượng thuốc trong kho</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($thuocData) && count($thuocData) > 0): ?>
                            <?php foreach ($thuocData as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($row['MaThuoc']) ?></td>
                                    <td><?= htmlspecialchars($row['TenThuoc']) ?></td>
                                    <td><?= htmlspecialchars($row['TenLoaiThuoc']) ?></td>
                                    <td><?= htmlspecialchars($row['TenNCC']) ?></td>
                                    <td><?= htmlspecialchars($row['GiaThuoc']) ?></td>
                                    <td><?= htmlspecialchars($row['SoLuongThuocTrongKho']) ?></td>
                                    <td>
                                    <a href="editThuoc.php?MaThuoc=<?= htmlspecialchars($row['MaThuoc']) ?>" class="btn btn-warning">Sửa</a>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="<?= $row['MaThuoc'] ?>">Xóa</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Không có dữ liệu thuốc.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal Thêm/Sửa -->
    

    <!-- Modal Xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Xóa thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xóa thuốc này không?</p>
            </div>
            <div class="modal-footer">
                <!-- Chuyển hướng đến deleteThuoc.php khi người dùng xác nhận xóa -->
                <form method="POST" action="deleteThuoc.php">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Lấy dữ liệu thuốc để xóa
    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const deleteId = document.getElementById('delete_id');
            deleteId.value = this.getAttribute('data-id');
        });
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
