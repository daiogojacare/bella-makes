<?php
session_start();
include('forms/config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $produto_id = $_GET['id'];

    $sql = "SELECT * FROM produtos WHERE id_produtos = '$produto_id'";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();
        $categoria = $produto['categoria'];

        $sql_produtos_relacionados = "SELECT * FROM produtos WHERE categoria = '$categoria' AND id_produtos != '$produto_id' LIMIT 4";
        $result_produtos_relacionados = $conexao->query($sql_produtos_relacionados);

        $produto_categoria = $produto['categoria'];
        ?>

        <!DOCTYPE html>
        <html lang="pt-br">

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
                    <a class="navbar-brand" href="index_loggedin.php"><img class="card-img-top"
                            src="assets/images/bellamakes.png" alt="..." style="width: 150px; height: auto;" /></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                            <li class="nav-item"><a
                                    class="nav-link <?php echo ($produto_categoria === 'Início') ? 'active' : ''; ?>"
                                    href="index_loggedin.php">Início</a></li>
                            <li class="nav-item"><a
                                    class="nav-link <?php echo ($produto_categoria === 'Roupas') ? 'active' : ''; ?>"
                                    href="roupas.php">Roupas</a></li>
                            <li class="nav-item"><a
                                    class="nav-link <?php echo ($produto_categoria === 'Maquiagens') ? 'active' : ''; ?>"
                                    href="maquiagens.php">Maquiagens</a></li>
                            <li class="nav-item"><a
                                    class="nav-link <?php echo ($produto_categoria === 'Acessórios') ? 'active' : ''; ?>"
                                    href="acessórios.php">Acessórios</a></li>
                        </ul>
                        <form class="d-flex" action="carrinho.php">
                            <button class="btn btn-outline-dark">
                                <i class="bi-cart-fill me-1"></i>
                                Carrinho
                                <span class="badge bg-dark text-white ms-1 rounded-pill">
                                    <?php echo isset($_SESSION['user']) && isset($_SESSION['carrinho'][$_SESSION['user']]) ? '(' . count($_SESSION['carrinho'][$_SESSION['user']]) . ')' : ''; ?>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
            <section class="py-5">
                <div class="container px-4 px-lg-5 my-5">
                    <div class="row gx-4 gx-lg-5 align-items-center">
                        <div class="col-md-6">
                            <img class="card-img-top mb-5 mb-md-0" src="<?php echo $produto['imagem']; ?>"
                                alt="<?php echo $produto['nome']; ?>" />
                        </div>
                        <div class="col-md-6">
                            <h1 class="display-5 fw-bolder">
                                <?php echo $produto['nome']; ?>
                            </h1>
                            <div class="fs-5 mb-5">
                                <span>R$
                                    <?php echo $produto['preco']; ?>
                                </span>
                            </div>
                            <p class="lead">
                                <?php echo nl2br($produto['descricao']); ?>
                            </p>
                            <form class="d-flex"
                                onsubmit="event.preventDefault(); adicionarCarrinho(<?php echo $produto['id_produtos']; ?>, <?php echo $produto['preco']; ?>)">
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    Adicionar ao Carrinho
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <section class="py-5 bg-light">
                <div class="container px-4 px-lg-5 mt-5">
                    <h2 class="fw-bolder mb-4">Produtos Relacionados</h2>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        <?php
                        if ($result_produtos_relacionados->num_rows > 0) {
                            while ($produto_relacionado = $result_produtos_relacionados->fetch_assoc()) {
                                ?>
                                <div class="col mb-5">
                                    <div class="card h-100">
                                        <img class="card-img-bottom" src="<?php echo $produto_relacionado['imagem']; ?>"
                                            alt="Imagem do produto" />
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <h5 class="fw-bolder">
                                                    <?php echo $produto_relacionado['nome']; ?>
                                                </h5>
                                                R$
                                                <?php echo $produto_relacionado['preco']; ?>
                                            </div>
                                        </div>
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <div class="text-center">
                                                <a class="btn btn-outline-dark mt-auto"
                                                    href="detalhes_produto_loggedin.php?id=<?php echo $produto_relacionado['id_produtos']; ?>">Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p>Nenhum produto relacionado encontrado.</p>';
                        }
                        ?>
                    </div>
                </div>
            </section>
            <div class="footer_section layout_padding">
                <div class="container">
                    <div class="footer_logo"><a href="index_loggedin.php"><img src="assets/images/bellamakes.png"
                                style="width: 20%; height: auto;"></a></div>
                    <div class="location_main">Número: <a href="https://wa.me/5548999198918">+55 (48) 9 9919-8918</a></div>
                </div>
            </div>
            <div class="copyright_section">
                <div class="container">
                    <p class="copyright_text">Copyright &copy; 2023 Todos os direitos reservados. Feito por <a
                            href="https://wa.me/5548999857701">Diogo Borges Corso</a></p>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/details.js"></script>
            <script>
                function adicionarCarrinho(produtoId, produtoPreco) {
                    window.location.href = 'forms/adicionar_carrinho.php?produto_id=' + produtoId + '&produto_preco=' + produtoPreco;
                }
            </script>
        </body>

        </html>

        <?php
    } else {
        echo '<p class="error-message">Produto não encontrado.</p>';
    }
} else {
    echo '<p class="error-message">ID do produto não especificado.</p>';
}
?>