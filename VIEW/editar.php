<?php
//VIEW/editar.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

require_once "../DAL/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = $_POST['id'];
    $nome    = $_POST['nome_fruta'];
    $preco   = $_POST['preco_quilo'];
    $estoque = $_POST['quantidade_estoque'];

    if (atualizarFruta($conexao, $id, $nome, $preco, $estoque)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mb-0 rounded-0'>Erro ao atualizar os dados!</div>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $fruta = buscarFrutaPorId($conexao, $id);
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hortifruti - Editar Fruta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">IL FRUTTETO DI FAMIGLIA</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link btn btn-outline-light btn-sm px-3 text-white" href="#">Sair</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white p-3">
                <h4 class="mb-0 fs-5">Alterar Dados da Fruta</h4>
            </div>
            <div class="card-body p-4">

                <form action="#" method="POST">

                    <input type="hidden" name="id" value="<?php echo $fruta['id']; ?>">

                    <div class="mb-3">
                        <label for="nome_fruta" class="form-label fw-bold text-secondary">Nome da Fruta</label>
                        <input type="text" class="form-control" id="nome_fruta" name="nome_fruta"
                            value="<?php echo $fruta['nome_fruta']; ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="preco_quilo" class="form-label fw-bold text-secondary">Preço por KG (R$)</label>
                            <input type="number" step="0.01" class="form-control" id="preco_quilo" name="preco_quilo"
                                value="<?php echo $fruta['preco_quilo']; ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quantidade_estoque" class="form-label fw-bold text-secondary">Qtd. em Estoque (KG)</label>
                            <input type="number" step="0.1" class="form-control" id="quantidade_estoque" name="quantidade_estoque"
                                value="<?php echo $fruta['quantidade_estoque']; ?>" required>
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary px-4">Voltar</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">Salvar Alterações</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>

</html>
