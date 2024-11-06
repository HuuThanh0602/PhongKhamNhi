<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Phòng Khám Nhi</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f4f4f9;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        /* Navbar styling */
        .navbar {
            width: 100%;
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .navbar .title {
            font-size: 24px;
            font-weight: bold;
        }
        .navbar .logout-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .navbar .btn-succes {
            background-color: green;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .navbar .logout-btn:hover {
            background-color: #e60000;
        }
        /* Container for the management boxes */
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            max-width: 800px;
            margin: 40px auto;
        }
        .box {
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color:sandybrown;
            color: white;
            font-size: 18px;
            text-align: center;
            cursor: pointer;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .box a {
            color: white;
            text-decoration: none;
            display: block;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php"); // Chuyển hướng về trang đăng nhập
    exit();
}
?>
<!-- Navbar -->
<div class="navbar">
    <div class="title">Quản Lý Phòng Khám Nhi</div>
    <div>
        <button class="btn-succes" onclick="window.location.href='../home/home.php'">Quay lại</button>
        <button class="logout-btn" onclick="window.location.href='../logout.php'">Đăng Xuất</button>
    
    </div>
    
</div>

<!-- Main Content with Management Boxes -->
 Nhi
<div class="container">
    
    <div class="box"><a href="Nhi/view_thongtinbennhan.php">Hiển thị thông tin, kết quả xét nghiệm và đơn thuốc (view)</a></div>
    <div class="box"><a href="Nhi/ham_doanhthu.php">Doanh thu một ngày (hàm)</a></div>
    <div class="box"><a href="Nhi/thutuc_cacloaixn.php">Thông tin các loại xét nghiệm và số lần thực hiện xét nghiệm (thủ tục)</a></div>

</div>
Phước
<div class="container">
    
    <div class="box"><a href="Phuoc/thongkekedon_ham.php">Thống kê đơn (Hàm)</a></div>
    <div class="box"><a href="Phuoc/thongkekedon_thutuc.php">Thống kê đơn (Thủ tục)</a></div>
    <div class="box"><a href="Phuoc/thongkekedon.php">Thống kê đơn (view)</a></div>
    
</div>
Quân
<div class="container">
    
    <div class="box"><a href="Quan/view_doanhthutheothang.php">Doanh thu theo tháng(view)</a></div>
    <div class="box"><a href="Quan/thutuc_doanhthutheonam.php">Doanh thu theo năm(Thủ tục)</a></div>
    <div class="box"><a href="Quan/ham_tongtienthuoc.php">Tổng tiền thuốc (Hàm)</a></div>
    
</div>

Sơn
<div class="container">
    
    
    <div class="box"><a href="Son/view.php">Phiếu thu (view)</a></div>
    <div class="box"><a href="Son/procedure.php">Số lượng thuốc trong kho (Thủ tục)</a></div>
    <div class="box"><a href="Son/function.php">Danh sách bệnh nhân đã tham gia xét nghiệm (Hàm) </a></div>
</div>
Thành
<div class="container"> 
    <div class="box"><a href="Thanh/view.php">Thống kê bệnh nhân (view)</a></div>
    <div class="box"><a href="Thanh/procedure.php"> Tổng chi phí cho một phiếu khám bệnh (Thủ tục)</a></div>
    <div class="box"><a href="Thanh/function.php"> Tiền xét nghiệm của một bệnh nhân (Hàm) </a></div>
</div>






</body>
</html>
