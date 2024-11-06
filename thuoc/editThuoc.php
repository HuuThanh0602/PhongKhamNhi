<?php
include '../Database/DBConnection.php';

if (isset($_GET['MaThuoc'])) {
    // Lấy mã thuốc từ URL
    $MaThuoc = $_GET['MaThuoc'];

    try {
        $db = new DBConnection();
        $pdo = $db->connect();

        if ($pdo) {
            // Lấy thông tin thuốc từ cơ sở dữ liệu
            $sql = "SELECT * FROM Thuoc WHERE MaThuoc = :MaThuoc";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':MaThuoc', $MaThuoc);
            $stmt->execute();
            $thuoc = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "edit") {
    $MaThuoc = $_POST['MaThuoc'];
    $TenThuoc = $_POST['TenThuoc'];
    $MaLoaiThuoc = $_POST['MaLoaiThuoc'];
    $MaNCC = $_POST['MaNCC'];
    $GiaThuoc = $_POST['GiaThuoc'];
    $SoLuongThuocTrongKho = $_POST['SoLuongThuocTrongKho'];

    try {
        $db = new DBConnection();
        $pdo = $db->connect();

        if ($pdo) {
            // Cập nhật thuốc vào cơ sở dữ liệu
            $sql = "UPDATE Thuoc SET TenThuoc = :TenThuoc, MaLoaiThuoc = :MaLoaiThuoc, MaNCC = :MaNCC, GiaThuoc = :GiaThuoc, SoLuongThuocTrongKho = :SoLuongThuocTrongKho 
                    WHERE MaThuoc = :MaThuoc";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':TenThuoc', $TenThuoc);
            $stmt->bindValue(':MaLoaiThuoc', $MaLoaiThuoc);
            $stmt->bindValue(':MaNCC', $MaNCC);
            $stmt->bindValue(':GiaThuoc', $GiaThuoc);
            $stmt->bindValue(':SoLuongThuocTrongKho', $SoLuongThuocTrongKho);
            $stmt->bindValue(':MaThuoc', $MaThuoc);

            $stmt->execute();

            // Sau khi cập nhật thành công, chuyển hướng về trang index.php
            header("Location: index.php");
            exit;
        } else {
            throw new Exception("Không thể kết nối đến cơ sở dữ liệu.");
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>



<!-- Modal Sửa Thuốc -->
<div class="container mt-5">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditModalLabel">Sửa thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="editThuoc.php">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="MaThuoc" value="<?= $thuoc['MaThuoc'] ?>">

                    <!-- Tên thuốc -->
                    <div class="mb-3">
                        <label for="TenThuoc" class="form-label">Tên thuốc</label>
                        <input type="text" class="form-control" id="TenThuoc" name="TenThuoc" value="<?= $thuoc['TenThuoc'] ?>" required>
                    </div>

                    <!-- Mã loại thuốc -->
                    <div class="mb-3">
                        <label for="MaLoaiThuoc" class="form-label">Mã loại thuốc</label>
                        <input type="text" class="form-control" id="MaLoaiThuoc" name="MaLoaiThuoc" value="<?= $thuoc['MaLoaiThuoc'] ?>" required>
                    </div>

                    <!-- Mã nhà cung cấp -->
                    <div class="mb-3">
                        <label for="MaNCC" class="form-label">Mã nhà cung cấp</label>
                        <input type="text" class="form-control" id="MaNCC" name="MaNCC" value="<?= $thuoc['MaNCC'] ?>" required>
                    </div>

                    <!-- Giá thuốc -->
                    <div class="mb-3">
                        <label for="GiaThuoc" class="form-label">Giá thuốc</label>
                        <input type="number" class="form-control" id="GiaThuoc" name="GiaThuoc" value="<?= $thuoc['GiaThuoc'] ?>" required>
                    </div>

                    <!-- Số lượng thuốc trong kho -->
                    <div class="mb-3">
                        <label for="SoLuongThuocTrongKho" class="form-label">Số lượng thuốc trong kho</label>
                        <input type="number" class="form-control" id="SoLuongThuocTrongKho" name="SoLuongThuocTrongKho" value="<?= $thuoc['SoLuongThuocTrongKho'] ?>" required>
                    </div>

                    <div class="modal-footer">
                        <a href="index.php" type="button" class="btn btn-secondary"><i>Quay lại</i></a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Thêm các CDN cho Bootstrap và jQuery (nếu cần) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>