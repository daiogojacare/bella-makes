<?php
session_start();
include('config.php');

if (isset($_SESSION['user']) && isset($_SESSION['carrinho'][$_SESSION['user']])) {
    $nome_usuario = $_SESSION['user'];

    // Verificar se o nome do usuário existe na tabela usuarios
    $sql_check_user = "SELECT id_usuarios FROM usuarios WHERE user = '$nome_usuario'";
    $result_check_user = $conexao->query($sql_check_user);

    if ($result_check_user->num_rows > 0) {
        $row = $result_check_user->fetch_assoc();
        $usuario_id = $row['id_usuarios'];

        // Captura a data e hora do pedido
        $data_pedido = date("Y-m-d H:i:s");

        // Iniciar transação para garantir a integridade dos dados
        $conexao->begin_transaction();

        // Código para inserir o pedido na tabela Pedidos
        $sql_pedido = "INSERT INTO pedidos (usuario_id, data_pedido, status) VALUES ('$usuario_id', '$data_pedido', 'pendente')";
        $result_pedido = $conexao->query($sql_pedido);

        if ($result_pedido) {
            $pedido_id = $conexao->insert_id; // Captura o ID do pedido inserido

            // Obter os itens do carrinho da sessão
            $carrinho = $_SESSION['carrinho'][$_SESSION['user']];

            // Verificar se o carrinho não está vazio
            if (!empty($carrinho)) {
                $erro_insercao = false; // Variável para controle de erro

                // Código para inserir os itens do pedido na tabela Itens_Pedido
                foreach ($carrinho as $item) {
                    $produto_id = $item['id'];
                    $quantidade = $item['quantidade'];
                    $preco_unitario = $item['preco'];

                    $sql_itens_pedido = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) VALUES ('$pedido_id', '$produto_id', '$quantidade', '$preco_unitario')";
                    $result_itens_pedido = $conexao->query($sql_itens_pedido);

                    // Se houver um erro na inserção de itens, defina a variável de erro
                    if (!$result_itens_pedido) {
                        $erro_insercao = true;
                        break; // Sai do loop em caso de erro
                    }
                }

                if ($erro_insercao) {
                    $conexao->rollback();
                    echo "Erro ao finalizar o pedido. Por favor, tente novamente.";
                } else {
                    // Limpar o carrinho após finalizar o pedido
                    unset($_SESSION['carrinho'][$_SESSION['user']]);

                    // Finalizar transação e confirmar alterações no banco de dados
                    $conexao->commit();
                    echo "Pedido finalizado com sucesso!";
                }
            } else {
                // Se o carrinho estiver vazio, exiba uma mensagem
                echo "Não foi possível finalizar o pedido. O carrinho está vazio.";
            }
        } else {
            // Se houver um erro na inserção do pedido, reverta a transação e exiba uma mensagem de erro
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
