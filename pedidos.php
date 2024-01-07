<?php
session_start();
include('forms/config.php');

if (isset($_SESSION['user']) && $_SESSION['nivel_acesso'] === 'adm') {
    $sql_pedidos_usuarios = "SELECT p.id_pedidos, p.data_pedido, p.status, 
                                    u.id_usuarios, u.nome AS nome_usuario, u.email AS email_usuario, 
                                    u.telefone AS telefone_usuario,
                                    ip.produto_id, ip.quantidade AS quantidade_produto, 
                                    ip.preco_unitario AS preco_unitario_produto,
                                    pr.nome AS nome_produto
                             FROM pedidos p
                             INNER JOIN usuarios u ON p.usuario_id = u.id_usuarios
                             INNER JOIN itens_pedido ip ON p.id_pedidos = ip.pedido_id
                             INNER JOIN produtos pr ON ip.produto_id = pr.id_produtos
                             ORDER BY u.id_usuarios"; 
    $result_pedidos_usuarios = $conexao->query($sql_pedidos_usuarios);
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="assets/images/icon.png" />
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script type="text/javascript" src="assets/js/bibliotecas.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/adm.css">
        <title>BellaMakes - ADM</title>
    </head>

    <body>
        <nav>
            <div class="logo-name">
                <div class="logo-image">
                    <img src="assets/images/icon.png" alt="">
                </div>
                <span class="logo_name">Bella Makes</span>
            </div>
            <div class="menu-items">
                <ul class="nav-links">
                    <li>
                        <a href="adm.php">
                            <i class="uil uil-shopping-bag"></i>
                            <span class="link-name">Produtos</span>
                        </a>
                    </li>
                    <li>
                        <a href="pedidos.php">
                            <i class="uil uil-truck"></i>
                            <span class="link-name">Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="clientes.php">
                            <i class="uil uil-user"></i>
                            <span class="link-name">Clientes</span>
                        </a>
                    </li>
                </ul>
                <ul class="logout-mode">
                    <li>
                        <a href="forms/sair.php">
                            <i class="uil uil-signout"></i>
                            <span class="link-name">Sair</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <section class="dashboard">
            <div class="top">
                <i class="uil uil-bars sidebar-toggle"></i>
            </div>
            <div class="dash-content">
            <div class="overview">
                <h2>Pedidos Atuais</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome do Usuário</th>
                                <th>Telefone do Usuário</th>
                                <th>Data do Pedido</th>
                                <th>Status</th>
                                <th>Detalhes dos Produtos</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lastUserId = null;

                            while ($row_pedido_usuario = $result_pedidos_usuarios->fetch_assoc()) {
                                if ($lastUserId !== $row_pedido_usuario['id_usuarios']) {
                                    if ($lastUserId !== null) {
                                        echo '</td><td colspan="5"></td></tr>'; 
                                    }
                                    echo '<tr>'; 
                                    echo '<td>' . $row_pedido_usuario['nome_usuario'] . '</td>';
                                    echo '<td>' . $row_pedido_usuario['telefone_usuario'] . '</td>';
                                    echo '<td>' . $row_pedido_usuario['data_pedido'] . '</td>';
                                    echo '<td>' . $row_pedido_usuario['status'] . '</td>';
                                    echo '<td>';
                                }

                                echo 'Produto: ' . $row_pedido_usuario['nome_produto'] . '<br>';
                                echo 'Quantidade: ' . $row_pedido_usuario['quantidade_produto'] . '<br>';
                                echo 'Preço Total: ' . ($row_pedido_usuario['preco_unitario_produto'] * $row_pedido_usuario['quantidade_produto']) . '<br>';

                                $lastUserId = $row_pedido_usuario['id_usuarios']; 
                            }

                            if ($lastUserId !== null) {
                                echo '</td><td colspan="5"></td></tr>'; 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <script src="assets/js/adm.js"></script>

    </body>

    </html>

<?php
} else {
    header("Location: forms/login.php");
    exit();
}
?>