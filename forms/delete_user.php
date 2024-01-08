<?php
session_start();
include('config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    $user = $_POST['user'];

    $deletePedidosQuery = "DELETE FROM pedidos WHERE usuario_id = (SELECT id_usuarios FROM usuarios WHERE user = ?)";
    $deletePedidosStmt = $conexao->prepare($deletePedidosQuery);
    $deletePedidosStmt->bind_param("s", $user);
    $deletePedidosStmt->execute();
    $deletePedidosStmt->close();

    $deleteQuery = "DELETE FROM usuarios WHERE user = ?";
    $deleteStmt = $conexao->prepare($deleteQuery);
    $deleteStmt->bind_param("s", $user);
    $deleteStmt->execute();
    $deleteStmt->close();

    header("Location: ../index.php");
    exit();
} else {
    header("Location: ../index.php"); 
    exit();
}
?>
