<?php
session_start();
include('forms/config.php');

if (isset($_SESSION['user'])) {
    $usuario_id = $_SESSION['user'];

    if (isset($_SESSION['carrinho'][$usuario_id]) && count($_SESSION['carrinho'][$usuario_id]) > 0) {
        $total = 0;
        foreach ($_SESSION['carrinho'][$usuario_id] as $item) {
            // Consulta ao banco de dados para obter detalhes do produto
            $produto_id = $item['id'];
            $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                $produto = $result->fetch_assoc();

                // Exibição dos detalhes do produto no carrinho
                echo "Produto ID: " . $produto['id_produtos'] . "<br>";
                echo "Nome: " . $produto['nome'] . "<br>";
                echo "Descrição: " . $produto['descricao'] . "<br>";
                echo "Preço: R$" . $item['preco'] . "<br>";
                echo "Imagem: <img src='" . $produto['imagem'] . "' alt='" . $produto['nome'] . "'><br><br>";

                $total += $item['preco'];
            } else {
                echo "Produto não encontrado.<br>";
            }
        }
        echo "Preço total do carrinho: R$" . $total;
    } else {
        echo "Seu carrinho está vazio.";
    }
} else {
    echo "Usuário não está logado.";
}


?>
