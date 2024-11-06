<?php
require_once '../../Database/DBConnection.php';

if (!isset($_GET['id'])) {
    die("Missing patient ID.");
}

$id = $_GET['id'];

$db = new DBConnection();
$conn = $db->connect();

// Delete patient
$query = "DELETE FROM BenhNhan WHERE MaBenhNhan = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$_SESSION['message'] = 'Xoá thành công.';
header('Location: benhnhan.php'); // Redirect to the patients list
exit();
