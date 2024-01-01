<?php
session_start();

if (isset($_SESSION['user'])) {
    $usuario_id = $_SESSION['user']; 

    if (isset($_SESSION['carrinho'][$usuario_id]) && count($_SESSION['carrinho'][$usuario_id]) > 0) {
        $total = 0;
        foreach ($_SESSION['carrinho'][$usuario_id] as $item) {
            $total += $item['preco'];
            echo "Produto ID: " . $item['id'] . ", Preço: R$" . $item['preco'] . "<br>";
        }
        echo "Preço total do carrinho: R$" . $total;
    } else {
        echo "Seu carrinho está vazio.";
    }
} else {
    echo "Usuário não está logado.";
}

?>
