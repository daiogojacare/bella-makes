<?php
session_start();
include('config.php');

if (isset($_SESSION['user']) && isset($_SESSION['carrinho'][$_SESSION['user']])) {
    $nome_usuario = $_SESSION['user'];

    $sql_check_user = "SELECT id_usuarios FROM usuarios WHERE user = '$nome_usuario'";
    $result_check_user = $conexao->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        $row = $result_check_user->fetch_assoc();
        $usuario_id = $row['id_usuarios'];

        $data_pedido = date("Y-m-d H:i:s");

        $conexao->begin_transaction();

        $sql_pedido = "INSERT INTO pedidos (usuario_id, data_pedido, status) VALUES ('$usuario_id', '$data_pedido', 'Pendente')";
        $result_pedido = $conexao->query($sql_pedido);

        if ($result_pedido) {
            $pedido_id = $conexao->insert_id; 

            $carrinho = $_SESSION['carrinho'][$_SESSION['user']];

            if (!empty($carrinho)) {
                $erro_insercao = false; 

                foreach ($carrinho as $item) {
                    $produto_id = $item['id'];
                    $quantidade = $item['quantidade'];
                    $preco_unitario = $item['preco'];

                    $sql_itens_pedido = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES ('$pedido_id', '$produto_id', '$quantidade', '$preco_unitario')";
                    $result_itens_pedido = $conexao->query($sql_itens_pedido);

                    if (!$result_itens_pedido) {
                        $erro_insercao = true;
                        break; 
                    }
                }

                if ($erro_insercao) {
                    $conexao->rollback();
                    echo "Erro ao finalizar o pedido. Por favor, tente novamente.";
                } else {
                    unset($_SESSION['carrinho'][$_SESSION['user']]);
                
                    $conexao->commit();
                    header("Location: obrigado.php");
                    exit();
                }
            } else {
                echo "Não foi possível finalizar o pedido. O carrinho está vazio.";
            }
        } else {
            $conexao->rollback();
            echo "Erro ao finalizar o pedido. Por favor, tente novamente.";
        }
    } else {
        echo "Nome do Usuário na Sessão: " . $nome_usuario . "<br>";
        echo "Usuário não encontrado na tabela 'usuarios'.<br>";
    }
} else {
    echo "Não foi possível finalizar o pedido. Carrinho vazio ou usuário não logado.";
}
?>
