<?php
class Conexao {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "trabalho";
    public $conn;

    public function __construct() {
        // Criar conexão
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Verificar conexão
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getConn() {
        return $this->conn;
    }
}
?>