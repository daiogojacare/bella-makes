<?php
session_start();
include('forms/config.php');

if (isset($_SESSION['user'])) {
    $usuario_id = $_SESSION['user'];

    // Consulta para buscar os pedidos do usuário na tabela Pedidos
    $sql_pedidos = "SELECT * FROM pedidos WHERE usuario_id = '$usuario_id'";
    $result_pedidos = $conexao->query($sql_pedidos);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Meus Pedidos</title>
    <!-- Adicione aqui seus estilos CSS ou links para frameworks de estilo -->
</head>

<body>
    <h1>Meus Pedidos</h1>

    <?php if ($result_pedidos->num_rows > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Data do Pedido</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_pedido = $result_pedidos->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row_pedido['id_pedidos']; ?></td>
                        <td><?php echo $row_pedido['data_pedido']; ?></td>
                        <td><?php echo $row_pedido['status']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Nenhum pedido encontrado.</p>
    <?php } ?>

</body>

</html>

<?php
} else {
    // Se o usuário não estiver logado, redireciona para a página de login ou outra página
    header("Location: login.php");
    exit();
}
?>
