<?php
    include('config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bella Makes</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="icon" href="../assets/images/icon.png" />
    <link href="../assets/css/login.css" rel="stylesheet">
</head>

<body class="align">

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>

    <div class="wrapper">
        <div class="logo">
            <img src="../assets/images/icon.png" alt="">
        </div>
        <div class="text-center mt-4 name" style="text-align: center; margin-top: 5px;">
            Bella Makes
        </div>
        <form action="recuperar_senha.php" method="post">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="email" name="email" id="user__email" placeholder="Digite seu e-mail:" autocomplete="off"
                    required>
            </div>
            <button type="submit" class="btn mt-3" name="submit">Recuperar Senha</button>
        </form>
    </div>

</body>

</html>