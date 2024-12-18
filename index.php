<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">

</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="my-logo">
                    <a class="navbar-brand" href="#">
                        <img src="images/logo2.png" alt="" class="img-fluid">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" href="./login.php">Đăng nhập</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Nội dung cần tìm" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Tìm</button>
                </form>
                </div>
            </div>
        </nav>
        <?php
session_start();
require_once 'Database/DBConnection.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password']; 
    $username = $_SESSION['username']; 
    $password = $_SESSION['password']; 

    try {
        $db = new DBConnection();
        $conn = $db->connect(); 
        if ($conn === null) {
            echo "<script>alert('Không thể kết nối đến cơ sở dữ liệu. Vui lòng kiểm tra thông tin đăng nhập của bạn.');</script>";
        } else {
            $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE TenDangNhap = :username AND MatKhau = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password); 
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($results) > 0) {           
                header("Location: home/home.php");
                exit();
            } else {
                echo "<script>alert('Tên người dùng hoặc mật khẩu không đúng.');</script>";
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('Lỗi: " . addslashes($e->getMessage()) . "');</script>"; 
    }
}
?>
    </header>
    <main class="container mt-5 mb-5">
    <div class="d-flex justify-content-center">
        <div class="card" style="width:400px; ">
            <div class="card-header">
                <h3>Đăng Nhập</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" >
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="txtUser"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="tên đăng nhập" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="txtPass"><i class="fas fa-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="mật khẩu" required>
                    </div>

                    <div class="row align-items-center remember">
                        <input type="checkbox"> Ghi Nhớ Tôi
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Đăng Nhập" class="btn float-end login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center ">
                    Bạn chưa có tài khoản?<a href="#" class="text-warning text-decoration-none">Đăng Ký</a>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="#" class="text-warning text-decoration-none">Quên mật khẩu?</a>
                </div>
            </div>
        </div>
    </div>
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

