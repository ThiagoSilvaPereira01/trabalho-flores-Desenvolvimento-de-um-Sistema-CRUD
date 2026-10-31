<?php
/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Classe de configuração e conexão com o banco de dados MySQL via PDO com auto-instalação
*******************************************************************************/

class Database {
    private $host = "localhost";
    private $db_name = "crud_db";
    private $username = "root";
    private $password = ""; // Padrão XAMPP: sem senha
    public $conn;

    public function getConnection(){
        $this->conn = null;

        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
        ];

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $exception) {
            // Se o erro for banco de dados não encontrado (1049), tenta criar e popular automaticamente
            if ($exception->getCode() == 1049 || strpos($exception->getMessage(), 'Unknown database') !== false) {
                try {
                    $rootDsn = "mysql:host=" . $this->host . ";charset=utf8mb4";
                    $rootConn = new PDO($rootDsn, $this->username, $this->password, $options);
                    $rootConn->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

                    // Conecta no banco recém-criado
                    $this->conn = new PDO($dsn, $this->username, $this->password, $options);

                    // Localiza e executa o script SQL para criar as tabelas e dados iniciais
                    $sqlPath = __DIR__ . '/../database/crud_db.sql';
                    if (!file_exists($sqlPath)) {
                        $sqlPath = __DIR__ . '/../../crud_db.sql';
                    }

                    if (file_exists($sqlPath)) {
                        $sql = file_get_contents($sqlPath);
                        $this->conn->exec($sql);
                    }

                    return $this->conn;
                } catch(PDOException $setupEx) {
                    $this->renderErrorScreen($setupEx->getMessage());
                    exit();
                }
            } else {
                $this->renderErrorScreen($exception->getMessage());
                exit();
            }
        }

        return $this->conn;
    }

    private function renderErrorScreen($errorMessage) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Erro de Banco de Dados | LTP</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
            <style>
                body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; padding: 40px 20px; }
                .card { max-width: 650px; margin: 0 auto; background: white; border-radius: 12px; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
                h2 { color: #dc2626; margin-top: 0; font-size: 1.4rem; display: flex; align-items: center; gap: 10px; }
                .error-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px; font-family: monospace; font-size: 0.9rem; color: #991b1b; margin: 20px 0; word-break: break-all; }
                ol { padding-left: 20px; line-height: 1.7; color: #475569; }
                .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 15px; }
            </style>
        </head>
        <body>
            <div class="card">
                <h2>⚠️ Erro ao Conectar ao Banco de Dados</h2>
                <div class="error-box"><?php echo htmlspecialchars($errorMessage); ?></div>
                <p><strong>Como resolver este problema no XAMPP:</strong></p>
                <ol>
                    <li>Certifique-se de que o <strong>MySQL</strong> está iniciado no <em>XAMPP Control Panel</em> (botão <em>Start</em>).</li>
                    <li>Acesse o <a href="http://localhost/phpmyadmin" target="_blank">phpMyAdmin</a> no navegador.</li>
                    <li>Clique na aba <strong>Importar</strong>.</li>
                    <li>Selecione o arquivo <code>crud_db.sql</code> presente na pasta do projeto e clique em <strong>Executar</strong>.</li>
                </ol>
                <p>Após seguir esses passos, recarregue esta página.</p>
                <a href="javascript:location.reload();" class="btn">🔄 Tentar Novamente</a>
            </div>
        </body>
        </html>
        <?php
    }
}
?>