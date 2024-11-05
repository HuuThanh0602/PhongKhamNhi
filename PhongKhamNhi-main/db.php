<?php
class DBConnection {
    private $serverName = "localhost";
    private $uid = "sa";
    private $pwd = "Nhi@123";
    private $database = 'BTLBV';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            // Chuỗi kết nối sử dụng driver sqlsrv
            $dsn = "sqlsrv:server=$this->serverName;Database=$this->database;";
            $this->conn = new PDO($dsn, $this->uid, $this->pwd);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Kết nối thành công"; 
        } catch (PDOException $e) {
            echo "Kết nối thất bại: " . $e->getMessage(); 
        }
        return $this->conn;
    }
}


$db = new DBConnection();
$db->connect();
?>
