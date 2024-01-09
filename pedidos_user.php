<?php
session_start();
include('forms/config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

$sql_pedidos_usuario = "SELECT p.id_pedidos, p.data_pedido, p.status 
                        FROM pedidos p
                        INNER JOIN usuarios u ON p.usuario_id = u.id_usuarios
                        WHERE u.user = ?
                        ORDER BY p.data_pedido DESC";

$stmt = $conexao->prepare($sql_pedidos_usuario);
if ($stmt) {
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result_pedidos_usuario = $stmt->get_result();
    $stmt->close();
} else {
    echo "Erro na preparação da consulta.";
    exit();
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Bella Makes</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/icon.png" />
    <link rel="stylesheet" href="assets/css/.css">
</head>

<body>

    <div class="container">
        <h2>Meus Pedidos</h2>
        <?php
        while ($row_pedido = $result_pedidos_usuario->fetch_assoc()) {
            $pedido_id = $row_pedido['id_pedidos'];
            $sql_detalhes_pedido = "SELECT ip.produto_id, ip.quantidade AS quantidade_produto, 
                                        ip.preco_unitario AS preco_unitario_produto,
                                        pr.nome AS nome_produto
                                    FROM itens_pedido ip
                                    INNER JOIN produtos pr ON ip.produto_id = pr.id_produtos
                                    WHERE ip.pedido_id = ?";
            
            $stmt_detalhes = $conexao->prepare($sql_detalhes_pedido);
            if ($stmt_detalhes) {
                $stmt_detalhes->bind_param("s", $pedido_id);
                $stmt_detalhes->execute();
                $result_detalhes_pedido = $stmt_detalhes->get_result();
                $stmt_detalhes->close();
            } else {
                echo "Erro na preparação da consulta de detalhes do pedido.";
                exit();
            }

            echo "<h3>Pedido #{$pedido_id}</h3>";
            echo "<p>Data do Pedido: {$row_pedido['data_pedido']}</p>";
            echo "<p>Status: {$row_pedido['status']}</p>";

            echo '<table class="table">';
            echo '<thead><tr><th>Nome do Produto</th><th>Quantidade</th><th>Subtotal</th></tr></thead>';
            echo '<tbody>';
            $total_pedido = 0;
            while ($row_detalhes = $result_detalhes_pedido->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row_detalhes['nome_produto'] . '</td>';
                echo '<td>' . $row_detalhes['quantidade_produto'] . '</td>';
                $subtotal_produto = $row_detalhes['preco_unitario_produto'] * $row_detalhes['quantidade_produto'];
                echo '<td>R$ ' . number_format($subtotal_produto, 2, ',', '.') . '</td>';
                echo '</tr>';
                $total_pedido += $subtotal_produto;
            }
            echo '</tbody>';
            echo '</table>';
            echo "<p>Total do Pedido: R$ " . number_format($total_pedido, 2, ',', '.') . "</p>";
            echo '<hr>';
        }
        ?>
    </div>

    <!-- Seus scripts JavaScript -->
</body>

</html>
