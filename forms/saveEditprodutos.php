<?php
include('config.php');
if(isset($_POST['update']))
{
    $id_produtos = $_POST['id_produtos'];
    $nome = ucfirst($_POST['nome']);
    $descricao = ucfirst($_POST['descricao']);
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];

    $sqlUpdate = "UPDATE produtos SET nome=?, descricao=?, preco=?, categoria=? WHERE id_produtos=?";
    $stmt = $conexao->prepare($sqlUpdate);
    if ($stmt) {
        $stmt->bind_param("ssssi", $nome, $descricao, $preco, $categoria, $id_produtos);
        if ($stmt->execute()) {
            $stmt->close();
        } else {
            echo "Erro na atualização: " . $conexao->error;
        }
    } else {
        echo "Erro na preparação da declaração: " . $conexao->error;
    }
}
header('Location: ../adm.php');
?>