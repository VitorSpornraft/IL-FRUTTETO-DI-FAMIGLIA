<?php
// VIEW/vendas/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../DAL/conexao.php";
$resultado = listarVendas($conexao);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA - Histórico de Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">IL FRUTTETO DI FAMIGLIA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="../index.php">Estoque</a>
                    <a class="nav-link" href="../vendas/index.php">Vendas</a>
                    <a class="nav-link" href="../usuarios/index.php">Usuários</a>
                </div>
                <div class="navbar-nav ms-auto align-items-center">
                    <span class="navbar-text me-3 text-white justify-content-end small">
                        Olá, <strong><?php echo $_SESSION['usuario_nome']; ?></strong>
                        (<span class="text-capitalize"><?php echo $_SESSION['usuario_perfil']; ?></span>)
                    </span>
                    <a class="btn btn-sm btn-outline-light px-3" href="../logout.php">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 900px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-secondary font-monospace m-0">Histórico de Vendas</h2>
            <a href="cadastrar.php" class="btn btn-success fw-bold shadow-sm">+ Registrar Venda</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fruta</th>
                            <th>Qtd (KG)</th>
                            <th>Valor Total</th>
                            <th>Data/Hora</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($venda = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $venda['id'] . "</td>";
                                echo "<td><strong>" . $venda['nome_fruta'] . "</strong></td>";
                                echo "<td>" . number_format($venda['quantidade_vendida'], 2, ',', '.') . " kg</td>";
                                echo "<td class='text-success fw-bold'>R$ " . number_format($venda['valor_total'], 2, ',', '.') . "</td>";
                                echo "<td>" . date('d/m/Y H:i', strtotime($venda['data_venda'])) . "</td>";
                                echo "<td class='text-center'>
                                        <a href='excluir.php?id=" . $venda['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Excluir registro de venda?');\">Estornar</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted py-4'>Nenhuma venda registrada.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="mt-4">
                    <a href="../index.php" class="btn btn-outline-secondary btn-sm">← Voltar para o Estoque</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
