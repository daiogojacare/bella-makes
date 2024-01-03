<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['user']) && !empty($_POST['senha'])) {
        include('forms/config.php');

        $user = $_POST['user'];
        $senha = $_POST['senha'];

        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE user = ? LIMIT 1");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            $_SESSION['error'] = 'Usuário ou senha incorretos.';
            header('Location: login.php');
            exit();
        } else {
            $row = $result->fetch_assoc();
            if (password_verify($senha, $row['senha'])) {
                $_SESSION['user'] = $row['user'];
                $_SESSION['nivel_acesso'] = $row['nivel_acesso'];
                if ($row['nivel_acesso'] == 'adm') {
                    header('Location: adm.php');
                    exit();
                } else {
                    header('Location: index_loggedin.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Usuário ou senha incorretos.';
                header('Location: login.php');
                exit();
            }
        }
    } else {
        $_SESSION['error'] = 'Preencha todos os campos.';
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bella Makes</title>
    <link rel="icon" href="assets/images/icon.png" />
    <link href="assets/css/login.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Xb/Lp8CP3ZF8TyCxjLKbXdYv4sTf9CwAl1L/YV+sg0xbX7TyqI2PgUjA/wmKcgCwjN5qf8bYt4fQOQ1O6Ofwkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="align">
    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
    <div class="wrapper">
        <div class="logo">
            <img src="assets/images/icon.png" alt="">
        </div>
        <div class="text-center mt-4 name" style="text-align: center; margin-top: 5px;" >Bella Makes</div>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<div class="error-msg" style="color: red; text-align: center;>' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        <form class="p-3 mt-3" action="login.php" method="POST">
            <div class="form-field">
                <i class="far fa-user"></i>
                <input type="text" name="user" id="login__user" placeholder="Usuário" required>
            </div>
            <div class="form-field">
                <i class="fas fa-key"></i>
                <input type="password" name="senha" id="login__password" placeholder="Senha" required>
            </div>
            <button type="submit" class="btn mt-3" name="submit">Entrar</button>
        </form>
        <div class="text-center fs-6 mt-3" style="text-align: center; margin-top: 5px;">
            <a href="#">Esqueceu sua senha?</a> ou <a href="registrar.php">Registrar</a>
        </div>
    </div>
</body>

</html>
