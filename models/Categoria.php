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
class Categoria {
    private $conn;
    private $table_name = "categorias";

    public $id;
    public $nome;

    public function __construct($db){
        $this->conn = $db;
    }

    // Usado para ler categorias
    function read(){
        $query = "SELECT id, nome FROM " . $this->table_name . " ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Usado para criar categoria
    function create(){
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome";
        $stmt = $this->conn->prepare($query);

        $this->nome=htmlspecialchars(strip_tags($this->nome));

        $stmt->bindParam(":nome", $this->nome);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Usado para ler uma única categoria
    function readOne(){
        $query = "SELECT id, nome FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nome = $row['nome'];
    }

    // Usado para atualizar a categoria
    function update(){
        $query = "UPDATE " . $this->table_name . " SET nome = :nome WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Usado para deletar a categoria
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>
