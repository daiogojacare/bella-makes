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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Bella Makes</title>
</head>

<body>
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-12 col-md-12 col-12">
                    <h3 class="display-5 mb-2 text-center">Seu Carrinho</h3>
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
                                    <table id="shoppingCart" class="table table-condensed table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="width:60%">Produto</th>
                                                <th style="width:12%">Preço</th>
                                                <th style="width:10%">Quantidade</th>
                                                <th style="width:16%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td data-th="Product">
                                                    <div class="row">
                                                        <div class="col-md-3 text-left">
                                                            <img src="<?php echo $produto['imagem']; ?>" alt=""
                                                                class="img-fluid d-none d-md-block rounded mb-2 shadow ">
                                                        </div>
                                                        <div class="col-md-9 text-left mt-sm-2">
                                                            <h4>
                                                                <?php echo $produto['nome']; ?>
                                                            </h4>
                                                            <p class="font-weight-light">
                                                                <?php echo $produto['descricao']; ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-th="Price">Preço Unitário: R$
                                                    <?php echo $item['preco']; ?>
                                                </td>
                                                <td data-th="Quantity">
                                                    <form method="post" action="forms/atualizar_carrinho.php">
                                                        <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                                        <input type="number" class="form-control form-control-lg text-center"
                                                            name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1"
                                                            max="99" onchange='this.form.submit()'>
                                                    </form>
                                                </td>
                                                <td data-th="Price">SubTotal: R$
                                                    <?php echo $subtotal; ?>
                                                </td>
                                                <td class="actions" data-th="">
                                                    <div class="text-right">
                                                        <form method="post" action="forms/deletar_produto_carrinho.php">
                                                            <button id="deleteButton"
                                                                class="btn btn-white border-secondary bg-white btn-md mb-2"
                                                                type="button">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            <input type="hidden" name="indice" value="<?php echo $indice; ?>">
                                                            <input type="submit" value="Deletar" style="display: none;">
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php
                                } else {
                                    echo "Produto não encontrado.<br>";
                                }
                            }
                            echo '
                                    <div class="float-right text-right">
                                        <h4>Preço total do carrinho: R$</h4>
                                        <h1>' . $total . '</h1>
                                    </div>
                                </div>
                                </div>';
                            ?>
                            <div class="row mt-4 d-flex align-items-center">
                                <div class="col-sm-6 order-md-2 text-right">
                                    <a href="forms/finalizar_pedido.php" class="btn btn-primary mb-4 btn-lg pl-5 pr-5">Finalizar
                                        Pedido</a>
                                </div>
                                <div class="col-sm-6 mb-3 mb-m-1 order-md-1 text-md-left">
                                    <a href="index_loggedin.php">
                                        <i class="fas fa-arrow-left mr-2"></i> Continue Comprando</a>
                                </div>
                            </div>
                        </div>
            </section>
            <?php
                        } else {
                            echo '<div class="container-fluid mt-100">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Carrinho</h5>
                                            </div>
                                            <div class="card-body cart">
                                                <div class="col-sm-12 empty-cart-cls text-center">
                                                    <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4 mr-3">
                                                    <h3><strong>Seu Carrinho está Vazio</strong></h3>
                                                    <h4>adicione algo ao seu carrinho</h4>
                                                    <a href="index_loggedin.php" class="btn btn-primary cart-btn-transform m-3" data-abc="true">Continue Comprando</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    } else {
                        echo "Usuário não está logado.";
                    }
                    ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script>
        var deleteButtons = document.querySelectorAll('form[action="forms/deletar_produto_carrinho.php"] button[type="button"]');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                this.parentElement.querySelector('input[type="submit"]').click();
            });
        });
    </script>

</body>

</html>