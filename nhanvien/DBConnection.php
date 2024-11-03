<?php

class DBConnection {
    private $host = '127.0.0.1'; 
    private $dbName = 'BTL'; 
    private $username = 'root'; 
    private $password = ''; 
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            // Chuỗi kết nối MySQL
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Kết nối thất bại: " . $e->getMessage();
        }
        return $this->conn;
    }

    public function disconnect() {
        $this->conn = null;
    }
}
