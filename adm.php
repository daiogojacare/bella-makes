<?php
session_start();
include('forms/config.php');
if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['nivel_acesso']) == 'adm')) {
    unset($_SESSION['user']);
    unset($_SESSION['senha']);
    header('Location: login.php');
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
$sql = "SELECT nome FROM usuarios WHERE user = '$user'";
$result = $conexao->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $logado = $row['nome'];
}

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT * FROM usuarios WHERE id_usuarios LIKE '%$data%' or nome LIKE '%$data%' or user LIKE '%$data%' ORDER BY id_usuarios DESC";
} else {
    $sql = "SELECT * FROM usuarios ORDER BY id_usuarios DESC";
}

if (isset($_POST['submit'])) {
    function limparDados($conexao, $dados)
    {
        $dados = trim($dados);
        $dados = mysqli_real_escape_string($conexao, $dados);
        return $dados;
    }

    $nome = limparDados($conexao, ucfirst($_POST['nome']));
    $descricao = limparDados($conexao, ucfirst($_POST['descricao']));
    $preco = limparDados($conexao, $_POST['preco']);
    $categoria = limparDados($conexao, $_POST['categoria']);

    $verificarExistencia = mysqli_query($conexao, "SELECT * FROM produtos WHERE nome = '$nome'");
    if (mysqli_num_rows($verificarExistencia) > 0) {
        $mensagemCadastro = 'Produto já cadastrado.';
    } else {
        $result = mysqli_query($conexao, "INSERT INTO produtos(nome, descricao, preco, categoria) 
            VALUES ('$nome', '$descricao', '$preco', '$categoria')");

        if ($result) {
            $mensagemCadastro = 'Produto cadastrado!';
        } else {
            $mensagemCadastro = 'Erro ao cadastrar o produto.';
        }
    }
}

$sql = "SELECT id_produtos, nome, descricao, preco, categoria FROM produtos";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="assets/js/bibliotecas.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/css/adm.css">
    <title>Bella Makes</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="assets/img/logo.png" alt="">
            </div>
            <span class="logo_name">Bella Makes</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="adm.php">
                        <i class="uil uil-shopping-bag"></i>
                        <span class="link-name">Produtos</span>
                    </a>
                </li>
            </ul>
            <ul class="logout-mode">
                <li>
                    <a href="forms/sair.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Sair</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content">
            <div class="overview">
                <a href="#" id="openProductModal" style="text-decoration: none;">
                    <div class="title">
                        <i class="uil uil-plus"></i>
                        <span class="text">Cadastrar Produto</span>
                    </div>
                </a>
                <h2>Produtos Disponíveis</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Categoria</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $user_data['nome'] . "</td>";
                                echo "<td>" . $user_data['descricao'] . "</td>";
                                echo "<td>" . $user_data['preco'] . "</td>";
                                echo "<td>" . $user_data['categoria'] . "</td>";
                                echo "<td>
                                <a class='btn btn-sm btn-primary' href='javascript:void(0);' onclick=\"openEditModal('{$user_data['id_produtos']}', '{$user_data['nome']}', '{$user_data['descricao']}', '{$user_data['preco']}', '{$user_data['categoria']}')\" title='Editar'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                        <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.650l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106.106a.5.5 0 0 1 0 .708l-10-10-.106.106a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 0 .708l10-10 .106-.106a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3zM3 13.5a.5.5 0 0 1 .5-.5H4V12a.5.5 0 0 1 .5-.5H5a.5.5 0 0 1 .5.5V12h.5a.5.5 0 0 1 .5.5V13a.5.5 0 0 1-.5.5H5V14a.5.5 0 0 1-.5.5H4a.5.5 0 0 1-.5-.5V13H3a.5.5 0 0 1-.5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                    </svg>
                                </a>
                                <a class='btn btn-sm btn-danger' href='forms/deleteprodutos.php?id_produtos=$user_data[id_produtos]' title='Deletar'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                        <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                    </svg>
                                </a>
                            </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="modal fade custom-modal" id="productModal" tabindex="-1" role="dialog"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Novos Produtos</h5>
                        <button type="button" class="close" id="closeModal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form_cadastro" action="adm.php" method="POST">
                            <input type="text" class="form-control" id="user_nome" autocomplete="off" placeholder="Nome"
                                name="nome" required>
                            <br>
                            <input type="text" class="form-control" id="user_descricao" autocomplete="off" placeholder="Descrição"
                                name="descricao" required>
                            <br>
                            <input type="text" class="form-control" id="user_preco" autocomplete="off"
                                                placeholder="Preço" name="preco" required 
                                                oninput="validarPreco(this)">
                            <br>
                            <select id="user_categoria" class="form-control" name="categoria" required>
                                <option value="" disabled selected>Selecione a categoria</option>
                                <option value="Roupas">Roupas</option>
                                <option value="Maquiagens">Maquiagens</option>
                                <option value="Acessórios">Acessórios</option>
                            </select>
                            <br>
                            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Cadastrar">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade custom-modal" id="editProductModal" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Editar Produto</h5>
                        <button type="button" class="close" id="closeEditModal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="forms/saveEditprodutos.php" method="POST">
                            <input type="hidden" name="id_produtos" id="editProductID" value="">
                            <div class="form-group">
                                <label for="editProductName">Nome:</label>
                                <input type="text" class="form-control" id="editProductName" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="editProductDescription">Descrição:</label>
                                <input type="text" class="form-control" id="editProductDescription" name="descricao" required>
                            </div>
                            <div class="form-group">
                                <label for="editProductPrice">Preço:</label>
                                <input type="text" class="form-control" id="editProductPrice" name="preco" required>
                            </div>
                            <div class="form-group">
                                <label for="editProductCategory">Categoria:</label>
                                <select class="form-control" id="editProductCategory" name="categoria" required>
                                    <option value="Roupas">Roupas</option>
                                    <option value="Maquiagens">Maquiagens</option>
                                    <option value="Acessórios">Acessórios</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function validarPreco(input) {
            let regex = /^\d+(\.\d{1,2})?|\d+(,\d{1,2})?$/;

            input.value = input.value.replace(',', '.');

            if (!regex.test(input.value)) {
                input.setCustomValidity('Por favor, insira um preço válido.');
            } else {
                input.setCustomValidity('');
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let inputPrice = document.getElementById('editProductPrice');

            inputPrice.addEventListener('input', function() {
                let enteredValue = this.value;

                enteredValue = enteredValue.replace(',', '.');

                if (isNaN(enteredValue) || (enteredValue.split('.').length > 2)) {
                    this.setCustomValidity('Por favor, insira um preço válido.');
                } else {
                    this.setCustomValidity('');
                }

                this.value = enteredValue;
            });
        });
    </script>
    <script>
        document.getElementById("openProductModal").addEventListener("click", function () {
            $('#productModal').modal('show');
        });

        function openEditModal(id, name, description, price, category) {
            document.getElementById("editProductID").value = id;
            document.getElementById("editProductName").value = name;
            document.getElementById("editProductDescription").value = description;
            document.getElementById("editProductPrice").value = price;
            document.getElementById("editProductCategory").value = category;
            $('#editProductModal').modal('show');
        }

        document.getElementById("closeEditModal").addEventListener("click", function () {
            $('#editProductModal').modal('hide');
        });

        document.getElementById("closeModal").addEventListener("click", function () {
            $('#productModal').modal('hide');
        });
    </script>

</body>

</html>