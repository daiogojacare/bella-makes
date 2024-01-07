<?php
session_start();
include('config.php');

if (isset($_GET['produto_id']) && isset($_GET['produto_preco'])) {
    $produto_id = $_GET['produto_id'];
    $produto_preco = $_GET['produto_preco'];

    if (isset($_SESSION['user'])) {
        $usuario_id = $_SESSION['user'];

        if (!isset($_SESSION['carrinho'][$usuario_id])) {
            $_SESSION['carrinho'][$usuario_id] = array();
        }

        $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
        $result = $conexao->query($sql);

        if ($result->num_rows > 0) {
            $produto = $result->fetch_assoc();

            $_SESSION['carrinho'][$usuario_id][] = array(
                'id' => $produto_id,
                'nome' => $produto['nome'],
                'preco' => $produto_preco,
                'imagem' => $produto['imagem'],
                'descricao' => $produto['descricao']
            );

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "Produto não encontrado.";
        }
    } else {
        header("Location: ../login.php");
        exit();
    }
} else {
    echo "Parâmetros inválidos para adicionar ao carrinho.";
}

?>