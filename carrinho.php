<?php
session_start();
include('forms/config.php');

$totalCarrinho = 0; // Variável para armazenar o total do carrinho

if (isset($_SESSION['user'])) {
    $usuario_id = $_SESSION['user'];

    if (isset($_SESSION['carrinho'][$usuario_id]) && count($_SESSION['carrinho'][$usuario_id]) > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="assets/images/icon.png" />
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
            <link rel="stylesheet" type="text/css" href="assets/css/carrinho.css">
            <title>Bella Makes</title>
        </head>

        <body>
            <div class="cart_section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <div class="cart_container">
                                <div class="cart_title">Carrinho<small> (
                                        <?php echo count($_SESSION['carrinho'][$usuario_id]); ?> item(s) no seu carrinho)
                                    </small></div>
                                <div class="cart_items">
                                    <ul class="cart_list">
                                        <?php foreach ($_SESSION['carrinho'][$usuario_id] as $item) {
                                            $produto_id = $item['id'];
                                            $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
                                            $result = $conexao->query($sql);

                                            if ($result->num_rows > 0) {
                                                $produto = $result->fetch_assoc();
                                                $totalItem = $item['preco'];
                                                $totalCarrinho += $totalItem;
                                                ?>
                                                <li class="cart_item clearfix">
                                                    <div class="cart_item_image"><img src="<?php echo $produto['imagem']; ?>"
                                                            alt="<?php echo $produto['nome']; ?>"></div>
                                                    <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                                        <div class="cart_item_name cart_info_col">
                                                            <div class="cart_item_title">Nome</div>
                                                            <div class="cart_item_text">
                                                                <?php echo $produto['nome']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="cart_item_description cart_info_col">
                                                            <div class="cart_item_title">Descrição</div>
                                                            <div class="cart_item_text">
                                                                <?php echo $produto['descricao']; ?>
                                                            </div>
                                                        </div>
                                                        <div class="cart_item_price cart_info_col">
                                                            <div class="cart_item_title">Preço</div>
                                                            <div class="cart_item_text">R$
                                                                <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php }
                                        } ?>
                                    </ul>
                                </div>
                                <div class="order_total">
                                    <div class="order_total_content text-md-right">
                                        <div class="order_total_title">Total:</div>
                                        <div class="order_total_amount">R$
                                            <?php echo number_format($totalCarrinho, 2, ',', '.'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart_buttons">
                                    <button type="button" class="button cart_button_clear" onclick="redirectToIndex()">Continue
                                        Comprando</button>
                                    <button type="button" class="button cart_button_checkout">Finalizar Pedido</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function redirectToIndex() {
                    window.location.href = 'index_loggedin.php';
                }
            </script>
        </body>

        </html>
        <?php
    } else {
        echo "Seu carrinho está vazio.";
    }
} else {
    echo "Usuário não está logado.";
}
?>