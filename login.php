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
        <form class="p-3 mt-3" action="forms/testLogin.php" method="POST">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="user" id="login__user" placeholder="Usuário" required>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="senha" id="login__password" placeholder="Senha">
            </div>
            <button type="submit" class="btn mt-3" name="submit">Entrar</button>
        </form>
        <div class="text-center fs-6" style="text-align: center; margin-top: 5px;">
            <a href="#">Esqueceu sua senha?</a> ou <a href="registrar.php">Registrar</a>
        </div>
    </div>

</body>

</html>