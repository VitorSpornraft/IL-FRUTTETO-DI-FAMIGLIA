<?php
//VIEW/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../DAL/conexao.php";

$sql = "SELECT * FROM produtos";
$resultado = mysqli_query($conexao, $sql);
$resumo = buscarResumoEstoque($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">IL FRUTTETO DI FAMIGLIA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="nav-link active fw-bold" href="index.php">Estoque</a>
                    <a class="nav-link" href="vendas/index.php">Vendas</a>
                    <a class="nav-link" href="lotes/index.php">Lotes</a>
                    <a class="nav-link" href="usuarios/index.php">Usuários</a>
                </div>
                <div class="navbar-nav ms-auto align-items-center">
                    <span class="navbar-text me-3 text-white justify-content-end small">
                        Olá, <strong><?php echo $_SESSION['usuario_nome']; ?></strong>
                        (<span class="text-capitalize"><?php echo $_SESSION['usuario_perfil']; ?></span>)
                    </span>
                    <a class="btn btn-sm btn-outline-light px-3" href="logout.php">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="container mt-5">

            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card bg-white border-0 shadow-sm h-100 border-start border-success border-4">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase small fw-bold">Variedade de Frutas</h6>
                            <h3 class="fw-bold text-dark m-0"><?php echo $resumo['total_especies']; ?> tipos</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card bg-white border-0 shadow-sm h-100 border-start border-info border-4">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase small fw-bold">Volume no Estoque</h6>
                            <h3 class="fw-bold text-dark m-0"><?php echo number_format($resumo['total_quilos'], 1, ',', '.'); ?> kg</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card bg-white border-0 shadow-sm h-100 border-start border-warning border-4">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase small fw-bold">Valor Estimado</h6>
                            <h3 class="fw-bold text-dark m-0">R$ <?php echo number_format($resumo['valor_total'], 2, ',', '.'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-secondary font-monospace">Gerenciamento de Estoque</h2>
                <a href="cadastrar.php" class="btn btn-success fw-bold shadow-sm">+ Cadastrar Nova Fruta</a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Fruta</th>
                                <th>Preço / KG</th>
                                <th>Qtd. em Estoque</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($resultado) > 0) {
                                while ($fruta = mysqli_fetch_assoc($resultado)) {
                                    echo "<tr>";
                                    echo "<td>" . $fruta['id'] . "</td>";
                                    echo "<td><strong>" . $fruta['nome_fruta'] . "</strong></td>";
                                    echo "<td>R$ " . number_format($fruta['preco_quilo'], 2, ',', '.') . "</td>";
                                    echo "<td>" . $fruta['quantidade_estoque'] . " kg</td>";
                                    echo "<td class='text-center'>
                                        <a href='editar.php?id=" . $fruta['id'] . "' class='btn btn-sm btn-warning me-1'>Editar</a>
                                        <a href='excluir.php?id=" . $fruta['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Voce tem certeza que deseja excluir a fruta " . $fruta['nome_fruta'] . "?');\">Excluir</a>
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted py-4'>Nenhum registro encontrado no estoque.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</body>

</html>
