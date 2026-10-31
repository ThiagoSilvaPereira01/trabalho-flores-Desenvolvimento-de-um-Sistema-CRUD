<?php
class Produto {
    private $conn;
    private $table_name = "produtos";

    public $id;
    public $nome;
    public $descricao;
    public $preco;
    public $categoria_id;
    public $categoria_nome;

    public function __construct($db){
        $this->conn = $db;
    }

    // Usado para ler produtos
    function read(){
        $query = "SELECT
                    c.nome as categoria_nome, p.id, p.nome, p.descricao, p.preco, p.categoria_id
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categorias c
                            ON p.categoria_id = c.id
                ORDER BY
                    p.nome DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Usado para criar produto
    function create(){
        $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, preco=:preco, descricao=:descricao, categoria_id=:categoria_id";
        $stmt = $this->conn->prepare($query);

        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->preco=htmlspecialchars(strip_tags($this->preco));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->categoria_id=htmlspecialchars(strip_tags($this->categoria_id));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":categoria_id", $this->categoria_id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Usado para ler um único produto
    function readOne(){
        $query = "SELECT
                    c.nome as categoria_nome, p.id, p.nome, p.descricao, p.preco, p.categoria_id
                FROM
                    " . $this->table_name . " p
                    LEFT JOIN
                        categorias c
                            ON p.categoria_id = c.id
                WHERE
                    p.id = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nome = $row["nome"];
        $this->descricao = $row["descricao"];
        $this->preco = $row["preco"];
        $this->categoria_id = $row["categoria_id"];
        $this->categoria_nome = $row["categoria_nome"];
    }

    // Usado para atualizar o produto
    function update(){
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nome = :nome,
                    preco = :preco,
                    descricao = :descricao,
                    categoria_id = :categoria_id
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nome=htmlspecialchars(strip_tags($this->nome));
        $this->preco=htmlspecialchars(strip_tags($this->preco));
        $this->descricao=htmlspecialchars(strip_tags($this->descricao));
        $this->categoria_id=htmlspecialchars(strip_tags($this->categoria_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // Usado para deletar o produto
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
