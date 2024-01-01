<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_SESSION['user']) && isset($_POST['indice'])) {
        $usuario_id = $_SESSION['user'];
        $indice = $_POST['indice'];

        if (isset($_SESSION['carrinho'][$usuario_id][$indice])) {
            unset($_SESSION['carrinho'][$usuario_id][$indice]);

            header("Location: ../carrinho.php");
            exit();
        }
    }
}

header("Location: ../carrinho.php");
exit();
?>
