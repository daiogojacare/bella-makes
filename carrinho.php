<?php
session_start();
include('forms/config.php');

if (isset($_SESSION['user'])) {
    $usuario_id = $_SESSION['user'];

    if (isset($_SESSION['carrinho'][$usuario_id]) && count($_SESSION['carrinho'][$usuario_id]) > 0) {
        $total = 0;
        foreach ($_SESSION['carrinho'][$usuario_id] as $indice => $item) {
            $produto_id = $item['id'];
            $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                $produto = $result->fetch_assoc();

                if (!isset($item['quantidade'])) {
                    $_SESSION['carrinho'][$usuario_id][$indice]['quantidade'] = 1;
                    $item['quantidade'] = 1; 
                }

                echo "Produto ID: " . $produto['id_produtos'] . "<br>";
                echo "Nome: " . $produto['nome'] . "<br>";
                echo "Descrição: " . $produto['descricao'] . "<br>";
                echo "Preço unitário: R$" . $item['preco'] . "<br>";

                echo "<form method='post' action='forms/atualizar_carrinho.php'>";
                echo "<input type='hidden' name='indice' value='$indice'>";
                echo "<input type='number' name='quantidade' value='{$item['quantidade']}' min='1' max='10' onchange='this.form.submit()'>";
                echo "</form><br>";

                $subtotal = $item['preco'] * $item['quantidade']; 
                echo "Subtotal: R$" . $subtotal . "<br>";

                echo "Imagem: <img src='" . $produto['imagem'] . "' alt='" . $produto['nome'] . "'><br><br>";

                $total += $subtotal; 
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
