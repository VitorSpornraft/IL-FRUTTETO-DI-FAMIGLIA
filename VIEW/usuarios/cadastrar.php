<?php
// VIEW/usuarios/cadastrar.php
require_once "../../DAL/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (inserirUsuario($conexao, $nome, $email, $senha)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mb-0 rounded-0'>Erro ao cadastrar o usuário! Verifique se o e-mail já existe.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA - Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">IL FRUTTETO DI FAMIGLIA</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link btn btn-outline-light btn-sm px-3 text-white" href="#">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white p-3">
                <h4 class="mb-0 fs-5">Novo Usuário do Sistema</h4>
            </div>
            <div class="card-body p-4">

                <form action="cadastrar.php" method="POST">

                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold text-secondary">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João Silva" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-secondary">E-mail (Login)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="joao@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label fw-bold text-secondary">Senha de Acesso</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="No mínimo 6 caracteres" required>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary px-4">Voltar</a>
                        <button type="submit" class="btn btn-success px-4 fw-bold">Salvar Usuário</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>

</html>
