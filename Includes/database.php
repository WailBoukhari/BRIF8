<?php
class Database
{
    private $host = "localhost";
    private $dbname = "ELECTRONACERV4";
    private $username = "root";
    private $password = "123";
    protected $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

// Create an instance of the Database class for reuse
$database = new Database();
$conn = $database->getConnection();
