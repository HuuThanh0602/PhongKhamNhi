<?php
include '../Database/DBConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == "add") {
    // Nhận dữ liệu từ form
    $TenThuoc = $_POST['TenThuoc'];
    $MaLoaiThuoc = $_POST['MaLoaiThuoc'];  // Nhập mã loại thuốc
    $MaNCC = $_POST['MaNCC'];              // Nhập mã nhà cung cấp
    $GiaThuoc = $_POST['GiaThuoc'];
    $SoLuongThuocTrongKho = $_POST['SoLuongThuocTrongKho'];

    try {
        $db = new DBConnection();
        $pdo = $db->connect();

        if ($pdo) {
            // Tạo mã thuốc tự động tăng
            $newMaThuoc = generateNewMaThuoc($pdo);

            // Thêm thuốc vào cơ sở dữ liệu
            $sql = "INSERT INTO Thuoc (MaThuoc, TenThuoc, MaLoaiThuoc, MaNCC, GiaThuoc, SoLuongThuocTrongKho) 
                    VALUES (:MaThuoc, :TenThuoc, :MaLoaiThuoc, :MaNCC, :GiaThuoc, :SoLuongThuocTrongKho)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':MaThuoc', $newMaThuoc);
            $stmt->bindValue(':TenThuoc', $TenThuoc);
            $stmt->bindValue(':MaLoaiThuoc', $MaLoaiThuoc);
            $stmt->bindValue(':MaNCC', $MaNCC);
            $stmt->bindValue(':GiaThuoc', $GiaThuoc);
            $stmt->bindValue(':SoLuongThuocTrongKho', $SoLuongThuocTrongKho);

            // Thực thi câu lệnh thêm thuốc
            $stmt->execute();

            // Sau khi lưu thành công, chuyển hướng về trang index.php
            header("Location: index.php");
            exit;  // Đảm bảo ngừng chạy mã sau khi chuyển hướng
        } else {
            throw new Exception("Không thể kết nối đến cơ sở dữ liệu.");
        }
    } catch (Exception $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

// Hàm tạo mã thuốc tự động tăng bằng cách đếm số lượng thuốc
function generateNewMaThuoc($pdo)
{
    // Đếm số lượng bản ghi trong bảng Thuoc
    $sql = "SELECT COUNT(*) FROM Thuoc";
    $stmt = $pdo->query($sql);
    $count = $stmt->fetchColumn();

    // Mã thuốc tiếp theo sẽ là 'TH' + (số lượng bản ghi + 1)
    $newNumber = $count + 1;

    // Tạo mã thuốc với 4 chữ số (ví dụ: TH0001, TH0002, ...)
    return 'TH' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
}
?>

<!-- HTML Form -->
<div class="container mt-5">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditModalLabel">Thêm thuốc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" method="POST" action="addThuoc.php">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <!-- Tên thuốc -->
                    <div class="mb-3">
                        <label for="TenThuoc" class="form-label">Tên thuốc</label>
                        <input type="text" class="form-control" id="TenThuoc" name="TenThuoc" required>
                    </div>

                    <!-- Mã loại thuốc -->
                    <div class="mb-3">
                        <label for="MaLoaiThuoc" class="form-label">Mã loại thuốc</label>
                        <input type="text" class="form-control" id="MaLoaiThuoc" name="MaLoaiThuoc" required>
                    </div>

                    <!-- Mã nhà cung cấp -->
                    <div class="mb-3">
                        <label for="MaNCC" class="form-label">Mã nhà cung cấp</label>
                        <input type="text" class="form-control" id="MaNCC" name="MaNCC" required>
                    </div>

                    <!-- Giá thuốc -->
                    <div class="mb-3">
                        <label for="GiaThuoc" class="form-label">Giá thuốc</label>
                        <input type="number" class="form-control" id="GiaThuoc" name="GiaThuoc" required>
                    </div>

                    <!-- Số lượng thuốc trong kho -->
                    <div class="mb-3">
                        <label for="SoLuongThuocTrongKho" class="form-label">Số lượng thuốc trong kho</label>
                        <input type="number" class="form-control" id="SoLuongThuocTrongKho" name="SoLuongThuocTrongKho" required>
                    </div>

                    <!-- Nút lưu -->
                    <div class="modal-footer">
                        <a href="index.php" type="button" class="btn btn-secondary"><i>Quay lại</i></a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Thêm các tệp liên kết cần thiết cho Bootstrap nếu chưa có -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>