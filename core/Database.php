<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $pdo;
    
    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    public function query($sql) {
        return $this->pdo->prepare($sql);
    }
    
    public function execute($stmt, $params = []) {
        return $stmt->execute($params);
    }
    
    public function fetchAll($stmt) {
        $this->execute($stmt);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
