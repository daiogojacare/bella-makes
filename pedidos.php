<?php
session_start();
include('forms/config.php');

if (isset($_SESSION['user']) && $_SESSION['nivel_acesso'] === 'adm') {
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
                            <i class="uil uil-shopping-bag"></i>
                            <span class="link-name">Pedidos</span>
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
                    <a style="text-decoration: none;">
                        <div class="title">
                            <i class="uil uil-plus"></i>
                            <span class="text">Pedidos</span>
                        </div>
                    </a>
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
                                <?php while ($row_pedido_usuario = $result_pedidos_usuarios->fetch_assoc()) { ?>
                                    <tr>
                                        <td>
                                            <?php echo $row_pedido_usuario['nome_usuario']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row_pedido_usuario['telefone_usuario']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row_pedido_usuario['data_pedido']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row_pedido_usuario['status']; ?>
                                        </td>
                                        <td>
                                            Produto:
                                            <?php echo $row_pedido_usuario['nome_produto']; ?><br>
                                            Quantidade:
                                            <?php echo $row_pedido_usuario['quantidade_produto']; ?><br>
                                            Preço Total:
                                            <?php echo $row_pedido_usuario['preco_unitario_produto'] * $row_pedido_usuario['quantidade_produto']; ?>
                                        </td>
                                        <td>
                                            <a class='btn btn-sm btn-danger'
                                                href='forms/deletepedidos.php?id_pedidos=$user_data[id_pedidos]'
                                                title='Deletar'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16'
                                                    fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                                    <path
                                                        d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z' />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>Nenhum pedido encontrado.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/adm.js"></script>

</body>

</html>