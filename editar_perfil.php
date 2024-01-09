<?php
session_start();
include('forms/config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

if (isset($_POST['action']) && $_POST['action'] === 'edit_profile') {
    $newNome = $_POST['nome'];
    $newEmail = $_POST['email'];
    $newTelefone = $_POST['telefone'];
    $novaSenha = $_POST['nova_senha'];

    if (!empty($novaSenha)) {
        $hashedNovaSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE usuarios SET nome=?, email=?, telefone=?, senha=? WHERE user=?";
        $updateStmt = $conexao->prepare($updateQuery);
        $updateStmt->bind_param("sssss", $newNome, $newEmail, $newTelefone, $hashedNovaSenha, $user);
        $updateStmt->execute();
        $updateStmt->close();

        $novaSenha = $novaSenha;
    } else {
        $updateQuery = "UPDATE usuarios SET nome=?, email=?, telefone=? WHERE user=?";
        $updateStmt = $conexao->prepare($updateQuery);
        $updateStmt->bind_param("ssss", $newNome, $newEmail, $newTelefone, $user);
        $updateStmt->execute();
        $updateStmt->close();
    }
}

$query = "SELECT nome, email, telefone, senha FROM usuarios WHERE user = ?";
$stmt = $conexao->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($nome, $email, $telefone, $senha);
    $stmt->fetch();
    $stmt->close();
} else {
    echo "Erro na preparação da consulta.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Bella Makes</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="icon" href="assets/images/icon.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #874947;
            color: #fff;
            border: none;
            border-radius: 25px;
            transition: background-color 0.3s ease;
            box-shadow: 3px 3px 3px #b1b1b1,
                -3px -3px 3px #fff;
            letter-spacing: 1.3px;
        }

        .btn-primary:hover {
            background-color: #503737;
        }

        .voltar {
            margin-left: -60%;
        }

        @media (max-width: 759px) {
            .row {
                margin-top: -20%;
            }

            form {
                margin-top: -10%;
            }
        }

        @media (max-width: 340px) {
            .row {
                margin-top: -40%;
            }

            form {
                margin-top: -20%;
            }
        }
    </style>
</head>

<body>
    <div class="text-center mt-3">
        <a href="index_loggedin.php" class="btn btn-primary voltar">Voltar</a>
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        width="150px" src="assets/images/icon.png"><span class="font-weight-bold">
                        <?php echo $user; ?>
                    </span><span class="text-black-50">
                        <?php echo $email; ?>
                    </span><span>
                    </span></div>
            </div>
            <div class="col-md-5 border-right">
                <form action="user.php" method="post">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Perfil</h4>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><label class="labels">Usuário (não editável)</label><input type="text"
                                    class="form-control" name="user" value="<?php echo $user; ?>" readonly></div>
                            <div class="col-md-6"><label class="labels">Nome</label><input type="text" name="nome"
                                    class="form-control" value="<?php echo $nome; ?>"></div>
                            <div class="col-md-12"><label class="labels">Email</label><input type="text" name="email"
                                    class="form-control" value="<?php echo $email; ?>"></div>
                            <div class="col-md-12"><label class="labels">Telefone ou Celular</label><input type="text"
                                    name="telefone" class="form-control" value="<?php echo $telefone; ?>"></div>
                            <div class="col-md-12">
                                <label class="labels">Nova Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="nova_senha" id="senhaInput">
                                    <button type="button" class="btn btn-outline-primary" id="showPasswordBtn">Mostrar
                                        Senha</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="edit_profile">
                        <div class="mt-5 text-center">
                            <button id="deleteAccountBtn" class="btn btn-primary">Deletar Conta</button>
                            <button class="btn btn-primary" type="submit" name="submit">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Confirmação de Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir sua conta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="forms/delete_user.php" method="post">
                        <input type="hidden" name="user" value="<?php echo $user; ?>">
                        <button type="submit" class="btn btn-danger" name="delete_account">Excluir Conta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const novaSenha = "<?php echo isset($novaSenha) ? 'true' : 'false'; ?>";
        const senhaInput = document.getElementById('senhaInput');
        const showPasswordBtn = document.getElementById('showPasswordBtn');

        if (novaSenha === 'true') {
            senhaInput.value = '';
        }

        showPasswordBtn.addEventListener('click', function () {
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                showPasswordBtn.textContent = 'Ocultar Senha';
            } else {
                senhaInput.type = 'password';
                showPasswordBtn.textContent = 'Mostrar Senha';
            }
        });
    });
</script>
<?php
if (!empty($novaSenha)) {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('senhaInput').value = '<?php echo $novaSenha; ?>';
        });
    </script>
    <?php
}
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('deleteAccountBtn').addEventListener('click', function (event) {
            event.preventDefault();

            var myModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'), {
                keyboard: false
            });
            myModal.show();
        });
    });
</script>


</html>