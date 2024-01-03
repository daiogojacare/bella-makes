<?php
session_start();
include('forms/config.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/icon.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/carrinho.css">
    <title>Bella Makes</title>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="p-2">
                    <h4>Seu Carrinho</h4>
                </div>
                <?php
                if (isset($_SESSION['user'])) {
                    $usuario_id = $_SESSION['user'];

                    if (isset($_SESSION['carrinho'][$usuario_id]) && count($_SESSION['carrinho'][$usuario_id]) > 0) {
                        $total = 0;
                        foreach ($_SESSION['carrinho'][$usuario_id] as $indice => $item) {
                            $produto_id = $item['id'];
                            $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
                            $result = $conexao->query($sql);

                            if ($result->num_rows > 0) {
                                $produto = $result->fetch_assoc();

                                if (!isset($item['quantidade'])) {
                                    $_SESSION['carrinho'][$usuario_id][$indice]['quantidade'] = 1;
                                    $item['quantidade'] = 1;
                                }

                                $subtotal = $item['preco'] * $item['quantidade'];
                                $total += $subtotal;
                                ?>
                                <div class="d-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded">
                                    <!-- Exibição dos detalhes do produto -->
                                    <div class="mr-1"><img class="rounded" src="<?php echo $produto['imagem']; ?>" width="70"></div>
                                    <div class="d-flex flex-column align-items-center product-details">
                                        <span class="font-weight-bold">
                                            <?php echo $produto['nome']; ?>
                                        </span>
                                        <div class="d-flex flex-row product-desc">
                                            <div class="size mr-1">
                                                <span class="text-grey">Descrição:</span>
                                                <span class="font-weight-bold">&nbsp;
                                                    <?php echo $produto['descricao']; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center qty">
                                        <form method="post" action="forms/atualizar_carrinho.php">
                                            <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                            <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1"
                                                max="10" onchange='this.form.submit()'>
                                        </form>
                                    </div>
                                    <div>
                                        <h5 class="text-grey">Preço Unitário: R$
                                            <?php echo $item['preco']; ?>
                                        </h5>
                                    </div>
                                    <div>
                                        <h5 class="text-grey">SubTotal: R$
                                            <?php echo $subtotal; ?>
                                        </h5>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <form method="post" action="forms/deletar_produto_carrinho.php">
                                            <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                            <input type="submit" value="Deletar">
                                        </form>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo "Produto não encontrado.<br>";
                            }
                        }
                        echo "<div>Preço total do carrinho: R$ " . $total . "</div>";

                        ?>
                        <div class="d-flex flex-row align-items-center mt-3 p-2 bg-white rounded">
                            <button class="btn btn-warning btn-block btn-lg ml-2 pay-button" type="button" onclick="continuarComprando()">Continuar
                                Comprando</button>
                        </div>
                        <div class=" d-flex flex-row align-items-center mt-3 p-2 bg-white rounded">
                                <button class="btn btn-warning btn-block btn-lg ml-2 pay-button" type="button"
                                    onclick="finalizarPedido()">Finalizar Pedido</button>
                        </div>
                        <?php
                    } else {
                        echo "Seu carrinho está vazio.";
                    }
                } else {
                    echo "Usuário não está logado.";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        function finalizarPedido() {
            window.location.href = 'forms/finalizar_pedido.php';
        }

        function continuarComprando() {
            window.location.href = 'index_loggedin.php';
        }
    </script>


</body>

</html>