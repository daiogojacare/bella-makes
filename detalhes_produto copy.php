<?php
include('forms/config.php');

if (isset($_GET['id'])) {
    $produto_id = $_GET['id'];

    $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();

        echo '<div class="product-details">';
        echo '<img src="' . $produto['imagem'] . '" alt="' . $produto['nome'] . '">';
        echo '<h2>' . $produto['nome'] . '</h2>';
        echo '<p>Preço: R$' . $produto['preco'] . '</p>';
        echo '<p>Descrição: ' . $produto['descricao'] . '</p>';
        echo '<p>Categoria: ' . $produto['categoria'] . '</p>';
        echo '</div>';
    } else {
        echo '<p class="error-message">Produto não encontrado.</p>';
    }
} else {
    echo '<p class="error-message">ID do produto não especificado.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Bella Makes</title>
        <link rel="icon" href="assets/images/icon.png" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="assets/css/details.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php"><img class="card-img-top" src="assets/images/bellamakes.png" alt="..." style="width: 150px; height: auto;" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Roupas</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Maquiagens</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Acessórios</a></li>
                    </ul>
                    <form class="d-flex">
                        <button class="btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Carrinho
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder">Nome</h1>
                        <div class="fs-5 mb-5">
                            <span>$40.00</span>
                        </div>
                        <p class="lead">Descrição</p>
                        <div class="d-flex">
                            <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                            <button class="btn btn-outline-dark flex-shrink-0" type="button">
                                <i class="bi-cart-fill me-1"></i>
                                Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5 bg-light">
            <div class="container px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Produtos Relacionados</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
                        <div class="card h-100">
                            <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="..." />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder">Nome</h5>
                                    $40.00
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Mais</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="footer_section layout_padding">
            <div class="container">
                <div class="footer_logo"><a href="index.php"><img src="assets/images/bellamakes.png" style="width: 20%; height: auto;"></a></div>
                <div class="location_main">Número: <a href="#">+55 (48) 9 1234-5678</a></div>
            </div>
        </div>
        <div class="copyright_section">
            <div class="container">
                <p class="copyright_text">Copyright &copy; 2023 Todos os direitos reservados. Feito por <a href="https://github.com/daiogojacare">Diogo Borges Corso</a></p>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/details.js"></script>
    </body>
</html>
