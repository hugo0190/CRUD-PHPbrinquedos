CREATE DATABASE IF NOT EXISTS loja_brinquedos;

USE loja_brinquedos;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    faixa_etaria VARCHAR(30) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0
);

INSERT INTO produtos
(nome, categoria, faixa_etaria, preco, estoque)
VALUES
('Bola de Futebol', 'Esportes', '5+', 39.90, 20),
('Quebra-Cabeça 100 peças', 'Educativo', '6+', 24.50, 15),
('Boneca Articulada', 'Bonecas', '3+', 59.90, 10);