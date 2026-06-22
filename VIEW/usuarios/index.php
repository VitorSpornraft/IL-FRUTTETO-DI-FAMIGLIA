<?php
// VIEW/usuarios/index.php
require_once "../../DAL/conexao.php";

// Puxa a lista de usuários através da DAL
$resultado = listarUsuarios($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIAF - Gerenciar Usuários</title>
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

    <div class="container mt-5" style="max-width: 900px;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-secondary font-monospace m-0">Controle de Usuários</h2>
            <a href="cadastrar.php" class="btn btn-success fw-bold shadow-sm">+ Novo Usuário</a>
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
                                echo "<td class='text-center'>
                                        <a href='editar.php?id=" . $user['id'] . "' class='btn btn-sm btn-warning me-1'>Editar</a>
                                        <a href='excluir.php?id=" . $user['id'] . "' 
                                           class='btn btn-sm btn-danger' 
                                           onclick=\"return confirm('Deseja realmente remover o acesso de " . $user['nome'] . "?');\">
                                           Excluir
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted py-4'>Nenhum usuário cadastrado no sistema.</td></tr>";
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