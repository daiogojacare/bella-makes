DROP TABLE IF EXISTS itens_pedido;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id_usuarios INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    user VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('adm', 'usuario') NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produtos (
    id_produtos INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL, 
    preco DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    imagem VARCHAR(255)
);

CREATE TABLE pedidos (
    id_pedidos INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pendente', 'Finalizado') NOT NULL DEFAULT 'Pendente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuarios) ON DELETE CASCADE
);

CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id_pedidos) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id_produtos) ON DELETE CASCADE
);