<?php

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    include('config.php');

    $id = $_GET['id'];

    // Check if the id exists in itens_pedidos table
    $sqlSelect = "SELECT * FROM itens_pedido WHERE id=?";
    $stmtSelect = $conexao->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $id);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    if ($result->num_rows > 0) {
        $sqlFetchPedidoId = "SELECT pedido_id FROM itens_pedido WHERE id=?";
        $stmtFetchPedidoId = $conexao->prepare($sqlFetchPedidoId);
        $stmtFetchPedidoId->bind_param("i", $id);
        $stmtFetchPedidoId->execute();
        $resultPedidoId = $stmtFetchPedidoId->get_result();

        if ($resultPedidoId->num_rows > 0) {
            $row = $resultPedidoId->fetch_assoc();
            $pedidoId = $row['pedido_id'];

            $sqlDeleteItens = "DELETE FROM itens_pedido WHERE id=?";
            $stmtDeleteItens = $conexao->prepare($sqlDeleteItens);
            $stmtDeleteItens->bind_param("i", $id);
            $stmtDeleteItens->execute();
            $stmtDeleteItens->close();

            $sqlDeletePedidos = "DELETE FROM pedidos WHERE id=?";
            $stmtDeletePedidos = $conexao->prepare($sqlDeletePedidos);
            $stmtDeletePedidos->bind_param("i", $pedidoId);
            $stmtDeletePedidos->execute();
            $stmtDeletePedidos->close();
        }
        
        $stmtFetchPedidoId->close();
    }

    $stmtSelect->close();
    $conexao->close();
}

header('Location: ../pedidos.php');
?>
