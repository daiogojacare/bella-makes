<?php
session_start();
include('forms/config.php');

if (isset($_SESSION['user']) && $_SESSION['nivel_acesso'] === 'adm') { // Verifica se o usuário é um administrador
    // Consulta para buscar todos os pedidos com informações do usuário na tabela Pedidos e Usuários
    $sql_pedidos_usuarios = "SELECT p.id_pedidos, p.data_pedido, p.status, 
                                    u.nome AS nome_usuario, u.email AS email_usuario, 
                                    u.telefone AS telefone_usuario,
                                    ip.produto_id, ip.quantidade AS quantidade_produto, 
                                    ip.preco_unitario AS preco_unitario_produto,
                                    pr.nome AS nome_produto
                             FROM pedidos p
                             INNER JOIN usuarios u ON p.usuario_id = u.id_usuarios
                             INNER JOIN itens_pedido ip ON p.id_pedidos = ip.pedido_id
                             INNER JOIN produtos pr ON ip.produto_id = pr.id_produtos";
    $result_pedidos_usuarios = $conexao->query($sql_pedidos_usuarios);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Pedidos - Painel do Administrador</title>
    <!-- Adicione aqui seus estilos CSS ou links para frameworks de estilo -->
</head>

<body>
    <h1>Pedidos - Painel do Administrador</h1>

    <?php if ($result_pedidos_usuarios->num_rows > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>ID do Pedido</th>
                    <th>Nome do Usuário</th>
                    <th>Email do Usuário</th>
                    <th>Telefone do Usuário</th>
                    <th>Data do Pedido</th>
                    <th>Status</th>
                    <th>Detalhes dos Produtos</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_pedido_usuario = $result_pedidos_usuarios->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row_pedido_usuario['id_pedidos']; ?></td>
                        <td><?php echo $row_pedido_usuario['nome_usuario']; ?></td>
                        <td><?php echo $row_pedido_usuario['email_usuario']; ?></td>
                        <td><?php echo $row_pedido_usuario['telefone_usuario']; ?></td>
                        <td><?php echo $row_pedido_usuario['data_pedido']; ?></td>
                        <td><?php echo $row_pedido_usuario['status']; ?></td>
                        <td>
                            Produto: <?php echo $row_pedido_usuario['nome_produto']; ?><br>
                            Quantidade: <?php echo $row_pedido_usuario['quantidade_produto']; ?><br>
                            Preço Total: <?php echo $row_pedido_usuario['preco_unitario_produto'] * $row_pedido_usuario['quantidade_produto']; ?>
                        </td>
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
    // Se o usuário não for um administrador, redireciona para a página de login ou outra página
    header("Location: login.php");
    exit();
}
?>
