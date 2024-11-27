<?php
class Database {
    private $host = 'localhost';
    private $db = 'project';
    private $user = 'root';
    private $pass = '';
    private $pdo;
    
    public function connect() {
        if ($this->pdo == null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db}";
                $this->pdo = new PDO($dsn, $this->user, $this->pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error: Could not connect. " . $e->getMessage());
            }
        }
        return $this->pdo;
    }

}
?>
