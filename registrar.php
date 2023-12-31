<?php

$error_message = '';

if (isset($_POST['submit'])) {
    include('forms/config.php');

    $user = mysqli_real_escape_string($conexao, $_POST['user']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $user_check_query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE user='$user'");
    $user_exists = mysqli_num_rows($user_check_query);

    if ($user_exists > 0) {
        $error_message = "Usuário já está cadastrado.";
    } else {
        $result = mysqli_query($conexao, "INSERT INTO usuarios(user,nome,senha,nivel_acesso) 
            VALUES ('$user','$nome','$senha_hash','usuario')"); 
        header('Location: login.php');
        exit();
    }
}
?>


<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bella Makes</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="icon" href="assets/images/icon.png" />
    <link href="assets/css/login.css" rel="stylesheet">
</head>

<body class="align">

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="wrapper">
        <div class="logo">
            <img src="assets/images/icon.png" alt="">
        </div>
        <div class="text-center mt-4 name" style="text-align: center; margin-top: 5px;">
            Bella Makes
        </div>
        <form class="p-3 mt-3" action="registrar.php" method="POST">
            <?php if (!empty($error_message)): ?>
                <p style="color: red; text-align: center;">
                    <?php echo $error_message; ?>
                </p>
            <?php endif; ?>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="user" id="user__user" placeholder="Usuário" autocomplete="off" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="nome" id="user__nome" placeholder="Nome" autocomplete="off" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="senha" id="login__password" placeholder="Senha">
            </div>
            <input type="hidden" class="input" id="user_nivel_acesso" autocomplete="on" name="nivel_acesso"
                value="usuario" required>
            <button type="submit" class="btn mt-3" name="submit">Cadastrar</button>
        </form>
        <div class="text-center fs-6" style="text-align: center; margin-top: 5px;">
            Já possui conta? <a href="login.php">Entre Aqui</a>
        </div>
    </div>

</body>

</html>