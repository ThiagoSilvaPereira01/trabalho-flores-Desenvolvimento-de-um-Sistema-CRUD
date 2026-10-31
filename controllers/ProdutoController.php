<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
             26011846-2 -  Arthur Vinicius de Freitas Videres
             26003401-2 -  Matheus Azamur Passos
             26006867-2 -  Dennis Gabriel de Oliveira
             26007484-2 -  Murilo da Silva Santos
             26003834-2 -  Thiago Pereira da Silva
Data: 31 de outubro de 2026
Descritivo:
Desenvolver um sistema CRUD  
 *******************************************************************************/
?>
<?php
include_once '../config/database.php';
include_once '../models/Produto.php';
include_once '../models/Categoria.php';

class ProdutoController {
    private $conn;
    private $produto;
    private $categoria;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->produto = new Produto($this->conn);
        $this->categoria = new Categoria($this->conn);
    }

    public function index() {
        $stmt = $this->produto->read();
        $num = $stmt->rowCount();
        return ['stmt' => $stmt, 'num' => $num];
    }

    public function create($nome, $descricao, $preco, $categoria_id) {
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        if($this->produto->create()) {
            return true;
        }
        return false;
    }

    public function readOne($id) {
        $this->produto->id = $id;
        $this->produto->readOne();
        return $this->produto;
    }

    public function update($id, $nome, $descricao, $preco, $categoria_id) {
        $this->produto->id = $id;
        $this->produto->nome = $nome;
        $this->produto->descricao = $descricao;
        $this->produto->preco = $preco;
        $this->produto->categoria_id = $categoria_id;
        if($this->produto->update()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $this->produto->id = $id;
        if($this->produto->delete()) {
            return true;
        }
        return false;
    }

    public function getCategorias() {
        $stmt = $this->categoria->read();
        return $stmt;
    }
}
?>
