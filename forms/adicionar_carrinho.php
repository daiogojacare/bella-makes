<?php
session_start();

if (isset($_GET['produto_id']) && isset($_GET['produto_preco'])) {
    $produto_id = $_GET['produto_id'];
    $produto_preco = $_GET['produto_preco'];

    if (isset($_SESSION['user'])) {
        $usuario_id = $_SESSION['user']; 

        if (!isset($_SESSION['carrinho'][$usuario_id])) {
            $_SESSION['carrinho'][$usuario_id] = array();
        }

        $_SESSION['carrinho'][$usuario_id][] = array(
            'id' => $produto_id,
            'preco' => $produto_preco
        );

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Usuário não está logado.";
    }
} else {
    echo "Parâmetros inválidos para adicionar ao carrinho.";
}

?>
