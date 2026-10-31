<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Controlador responsável pela lógica de negócios da entidade Categoria
*******************************************************************************/

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/Categoria.php';

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
        $num = $stmt ? $stmt->rowCount() : 0;
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
        try {
            if($this->categoria->delete()) {
                return true;
            }
        } catch (\PDOException $e) {
            // Em caso de chave estrangeira com RESTRICT, impede o erro fatal
            return false;
        }
        return false;
    }
}
?>