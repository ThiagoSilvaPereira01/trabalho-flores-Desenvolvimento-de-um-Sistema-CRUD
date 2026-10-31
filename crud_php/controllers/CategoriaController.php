<?php
include_once '../config/database.php';
include_once '../models/Categoria.php';

class CategoriaController {
    private $conn;
    private $categoria;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->categoria = new Categoria($this->conn);
    }

    public function index() {
        $stmt = $this->categoria->read();
        $num = $stmt->rowCount();
        return ['stmt' => $stmt, 'num' => $num];
    }

    public function create($nome) {
        $this->categoria->nome = $nome;
        if($this->categoria->create()) {
            return true;
        }
        return false;
    }

    public function readOne($id) {
        $this->categoria->id = $id;
        $this->categoria->readOne();
        return $this->categoria;
    }

    public function update($id, $nome) {
        $this->categoria->id = $id;
        $this->categoria->nome = $nome;
        if($this->categoria->update()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $this->categoria->id = $id;
        if($this->categoria->delete()) {
            return true;
        }
        return false;
    }
}
?>
