/******************************************************************************
Curso: Tecnologia em Análise e Desenvolvimento de Sistemas
Disciplina: Linguagem e Técnicas de Programação
Professor: Flores
Turma: ADS2B
Componentes: 
 [Preencher com os nomes e RAs dos 5 integrantes]
Data: 15 de Novembro de 2026
Descritivo: Script de criação do banco de dados 'crud_db', tabelas e carga inicial de dados
*******************************************************************************/

-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS crud_db
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE crud_db;

-- Limpeza de tabelas prévias se existirem (respeitando a ordem das chaves estrangeiras)
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS categorias;

-- ============================================================================
-- Tabela: categorias
-- ============================================================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Tabela: produtos
-- ============================================================================
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT NULL,
    preco DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    categoria_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produtos_categorias 
        FOREIGN KEY (categoria_id) 
        REFERENCES categorias(id) 
        ON DELETE RESTRICT 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- Carga Inicial de Dados (Seed Data)
-- ============================================================================

-- Inserindo categorias de exemplo
INSERT INTO categorias (id, nome) VALUES
(1, 'Hardware & Computadores'),
(2, 'Periféricos & Acessórios'),
(3, 'Móveis de Escritório'),
(4, 'Áudio & Vídeo');

-- Inserindo produtos de exemplo
INSERT INTO produtos (id, nome, descricao, preco, categoria_id) VALUES
(1, 'Notebook Dell Inspiron 15', 'Processador Intel Core i7 12ª Geração, 16GB RAM, SSD 512GB NVMe, Tela 15.6 FHD.', 4299.90, 1),
(2, 'Teclado Mecânico RGB Switch Blue', 'Teclado mecânico gamer ABNT2 com iluminação RGB personalizável e anti-ghosting.', 289.50, 2),
(3, 'Mouse Sem Fio Ergonômico 16000 DPI', 'Sensor óptico de alta precisão com bateria recarregável e pegada anatômica.', 179.90, 2),
(4, 'Monitor LED 27 polegadas 144Hz', 'Painel IPS Full HD com tempo de resposta de 1ms e suporte ajustável.', 1199.00, 1),
(5, 'Cadeira Ergonômica Presidente', 'Suporte lombar ajustável, braços 3D, revestimento em tela mesh respirável.', 850.00, 3),
(6, 'Mesa para Computador em L', 'Estrutura reforçada em aço carbono com tampo em MDF de 25mm na cor freijó.', 620.00, 3),
(7, 'Headset Gamer 7.1 Surround', 'Drivers de 50mm, microfone com cancelamento de ruído e iluminação LED lateral.', 249.90, 4),
(8, 'Webcam Full HD 1080p 60fps', 'Microfone duplo integrado e foco automático ideal para reuniões e transmissões.', 219.00, 4);
