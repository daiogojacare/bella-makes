<?php
$error_message = '';

if (isset($_POST['submit'])) {
    include('forms/config.php');

    $user = mysqli_real_escape_string($conexao, $_POST['user']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);
    $senha_confirmar = mysqli_real_escape_string($conexao, $_POST['confirmar_senha']);
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $telefone = mysqli_real_escape_string($conexao, $_POST['telefone']);

    $user_check_query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE user='$user'");
    $email_check_query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE email='$email'");

    $user_exists = mysqli_num_rows($user_check_query);
    $email_exists = mysqli_num_rows($email_check_query);

    if ($user_exists > 0) {
        $error_message = "Usuário já está cadastrado.";
    } elseif ($email_exists > 0) {
        $error_message = "Email já está cadastrado.";
    } elseif ($senha !== $senha_confirmar) {
        $error_message = "As senhas não coincidem. Por favor, tente novamente.";
    } else {
        $result = mysqli_query($conexao, "INSERT INTO usuarios(user,nome,senha,nivel_acesso,email,telefone) 
            VALUES ('$user','$nome','$senha_hash','usuario','$email','$telefone')");
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
        <form class="p-3 mt-3" action="registrar.php" method="POST" onsubmit="return validarTelefone()">
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
                <span class="far fa-user"></span>
                <input type="email" name="email" id="user__email" placeholder="Email" autocomplete="off" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="hidden" id="codigo_pais" value="(+55)">
                <input type="text" name="telefone" id="user__telefone" placeholder="Telefone ou Celular"
                    autocomplete="off" required oninput="atualizarCampo()">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="senha" id="login__password" placeholder="Senha" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="confirmar_senha" id="confirmar__password" placeholder="Confirme a Senha" required>
            </div>
            <input type="hidden" class="input" id="user_nivel_acesso" autocomplete="on" name="nivel_acesso"
                value="usuario" required>
            <button type="submit" class="btn mt-3" name="submit">Cadastrar</button>
        </form>
        <div class="text-center fs-6" style="text-align: center; margin-top: 5px;">
            Já possui conta? <a href="login.php">Entre Aqui</a>
        </div>
    </div>
    <script>
        function atualizarCampo() {
            var codigoPais = document.getElementById('codigo_pais').value;
            var campoTelefone = document.getElementById('user__telefone');

            if (!campoTelefone.value.startsWith(codigoPais)) {
                campoTelefone.value = codigoPais;
            }
        }

        function validarTelefone() {
            var campoTelefone = document.getElementById('user__telefone');
            var numeroTelefone = campoTelefone.value.replace(/\D/g, '');

            if (numeroTelefone.length !== 13) {
                alert('O número de telefone deve conter 11 dígitos.');
                return false; 
            }

            return true; 
        }
    </script>

</body>

</html>
