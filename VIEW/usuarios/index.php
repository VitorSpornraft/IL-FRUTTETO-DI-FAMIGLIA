<?php
// VIEW/usuarios/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$perfil_usuario = $_SESSION['usuario_perfil'];

require_once "../../DAL/conexao.php";
$resultado = listarUsuarios($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA - Gerenciar Usuários</title>
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
                    <a class="nav-link" href="../lotes/index.php">Lotes</a>
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
            <h2 class="text-secondary font-monospace m-0">Controle de Usuários</h2>
            <?php if ($perfil_usuario === 'admin'): ?>
                <a href="cadastrar.php" class="btn btn-success fw-bold shadow-sm">+ Novo Usuário</a>
            <?php endif; ?>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome Completo</th>
                            <th>E-mail (Login)</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($user = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $user['id'] . "</td>";
                                echo "<td><strong>" . $user['nome'] . "</strong></td>";
                                echo "<td>" . $user['email'] . "</td>";

                                echo "<td class='text-center'>";
                                if ($perfil_usuario === 'admin') {
                                    echo "<a href='editar.php?id=" . $user['id'] . "' class='btn btn-sm btn-warning me-1'>Editar</a>";
                                    echo "<a href='excluir.php?id=" . $user['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Deseja excluir?');\">Excluir</a>";
                                } else {
                                    echo "<span class='badge bg-light text-muted border'>Acesso Restrito</span>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted py-4'>Nenhum usuário cadastrado.</td></tr>";
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
