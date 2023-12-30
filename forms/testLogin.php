<?php
session_start();

if (isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['senha'])) {
    include('config.php');
    $user = $_POST['user'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE user = '$user' AND senha = '$senha'";

    $result = $conexao->query($sql);

    if (mysqli_num_rows($result) < 1) {
        unset($_SESSION['user']);
        unset($_SESSION['senha']);
        header('Location: ../login.php');
    } else {
        $row = mysqli_fetch_assoc($result);
        if ($row['nivel_acesso'] == 'adm') {
            $_SESSION['user'] = $user;
            $_SESSION['senha'] = $senha;
            header('Location: ../adm.php');
        } else {
            $_SESSION['user'] = $user;
            $_SESSION['senha'] = $senha;
            header('Location: ../indexuser.php');
        }
    }
} else {
    header('Location: ../login.php');
} 
?>