<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['user']) && isset($_POST['indice']) && isset($_POST['quantidade'])) {
        $usuario_id = $_SESSION['user'];
        $indice = $_POST['indice'];
        $nova_quantidade = $_POST['quantidade'];

        if (isset($_SESSION['carrinho'][$usuario_id][$indice])) {
            $_SESSION['carrinho'][$usuario_id][$indice]['quantidade'] = $nova_quantidade;
        }

        header("Location: ../carrinho.php");
        exit();
    }
}

header("Location: carrinho.php");
exit();
?>
