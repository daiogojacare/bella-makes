<?php

if (!empty($_GET['id_pedidos'])) {
    include('config.php');

    $id_pedidos = $_GET['id_pedidos'];

    $sqlSelect = "SELECT *  FROM pedidos WHERE id_pedidos=$id_pedidos";

    $result = $conexao->query($sqlSelect);

    if ($result->num_rows > 0) {
        $sqlDelete = "DELETE FROM pedidos WHERE id_pedidos=$id_pedidos";
        $resultDelete = $conexao->query($sqlDelete);
    }
}
header('Location: ../pedidos.php');

?>