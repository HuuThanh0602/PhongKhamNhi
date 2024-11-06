<?php
include '../../Database/DBConnection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    try {
        $db = new DBConnection();
        $pdo = $db->connect();

        if ($pdo) {
            // Bắt đầu giao dịch
            $pdo->beginTransaction();

            // Xóa dữ liệu trong bảng Thuoc
            $sql = "DELETE FROM Thuoc WHERE MaThuoc = :MaThuoc";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':MaThuoc', $delete_id);
            $stmt->execute();

            // Commit giao dịch
            $pdo->commit();

            // Sau khi xóa xong, chuyển hướng về trang index.php
            header('Location: index.php');
            exit();
        }
    } catch (Exception $e) {
        // Nếu có lỗi, rollback giao dịch
        $pdo->rollBack();
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    echo "Không có thông tin thuốc để xóa.";
}
?>