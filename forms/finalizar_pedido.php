<?php
session_start();
include('config.php');

if (isset($_SESSION['user']) && isset($_SESSION['carrinho'][$_SESSION['user']])) {
    $usuario_id = $_SESSION['user'];
    $carrinho = $_SESSION['carrinho'][$usuario_id];

    // Verificar se 'nome_usuario' e 'email_usuario' estão definidos na sessão
    if (isset($_SESSION['nome_usuario']) && isset($_SESSION['email_usuario'])) {
        $nomeUsuario = $_SESSION['nome_usuario'];
        $emailUsuario = $_SESSION['email_usuario'];

    // Código para inserir dados do usuário na tabela Usuários
    $sql_usuario = "INSERT INTO usuarios (nome, email) VALUES ('$nomeUsuario', '$emailUsuario')";
    $conexao->query($sql_usuario);
    $usuario_id_inserido = $conexao->insert_id; // Captura o ID do usuário inserido

    // Captura a data e hora do pedido
    $data_pedido = date("Y-m-d H:i:s");

    // Código para inserir o pedido na tabela Pedidos
    $sql_pedido = "INSERT INTO pedidos (usuario_id, data_pedido, status) VALUES ('$usuario_id_inserido', '$data_pedido', 'pendente')";
    $conexao->query($sql_pedido);
    $pedido_id = $conexao->insert_id; // Captura o ID do pedido inserido

    // Código para inserir os itens do pedido na tabela Itens_Pedido
    foreach ($carrinho as $item) {
        $produto_id = $item['id'];
        $quantidade = $item['quantidade'];
        $preco_unitario = $item['preco'];

        $sql_itens_pedido = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES ('$pedido_id', '$produto_id', '$quantidade', '$preco_unitario')";
        $conexao->query($sql_itens_pedido);
    }

    // Limpa o carrinho após finalizar o pedido
    unset($_SESSION['carrinho'][$usuario_id]);

    echo "Pedido finalizado com sucesso!";
} else {
    echo "Dados do usuário não estão definidos na sessão.";
}
} else {
echo "Não foi possível finalizar o pedido. Carrinho vazio ou usuário não logado.";
}
?>