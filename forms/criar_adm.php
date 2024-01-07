<?php
include('config.php');

$user_exists_query = mysqli_query($conexao, "SELECT * FROM usuarios WHERE user='admin'");
$user_exists = mysqli_num_rows($user_exists_query);

if ($user_exists === 0) {
    $nome_admin = "Bella Makes";
    $user_admin = "bellamakes";
    $email_admin = "bellamakes@gmail.com";
    $telefone_admin = "123123";
    $senha_admin = "123123";

    $senha_hash_admin = password_hash($senha_admin, PASSWORD_DEFAULT);

    $result = mysqli_query($conexao, "INSERT INTO usuarios (user, nome, email, telefone, senha, nivel_acesso) 
                VALUES ('$user_admin', '$nome_admin', '$email_admin', '$telefone_admin', '$senha_hash_admin', 'adm')");

    if ($result) {
        header('Location: ../index.php');
        exit();
    }
}
?>
