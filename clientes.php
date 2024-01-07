<?php
session_start();

include('forms/config.php');

if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['nivel_acesso']) == 'adm')) {
    unset($_SESSION['user']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
$sql = "SELECT nome FROM usuarios WHERE user = '$user'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $logado = $row['nome'];
}

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM usuarios WHERE id_usuarios LIKE '%$data%' or nome LIKE '%$data%' or user LIKE '%$data%' ORDER BY id_usuarios DESC";
} else {
    $sql = "SELECT * FROM usuarios ORDER BY id_usuarios DESC";
}

if (isset($_POST['submit'])) {
    function limparDados($conexao, $dados)
    {
        $dados = trim($dados);
        $dados = mysqli_real_escape_string($conexao, $dados);
        return $dados;
    }

    $user = limparDados($conexao, $_POST['user']);
    $nome = limparDados($conexao, $_POST['nome']);
    $email = limparDados($conexao, $_POST['email']);
    $telefone = limparDados($conexao, $_POST['telefone']);

}

$sql = "SELECT id_usuarios, user, nome, email, telefone FROM usuarios";
$result = $conexao->query($sql);
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
                <h2>Clientes</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $user_data['user'] . "</td>";
                                echo "<td>" . $user_data['nome'] . "</td>";
                                echo "<td>" . $user_data['email'] . "</td>";
                                echo "<td>" . $user_data['telefone'] . "</td>";
                                echo "<td>
                                <a class='btn btn-sm btn-danger' href='forms/deleteuser.php?id_usuarios=$user_data[id_usuarios]' title='Deletar'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                        <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                    </svg>
                                </a>
                            </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/adm.js"></script>

</body>

</html>