<?php
//VIEW/index.php

require_once "../DAL/conexao.php";

$sql = "SELECT * FROM produtos";
$resultado = mysqli_query($conexao, $sql);
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
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link active px-3" href="index.php">Estoque de Frutas</a>
                    <a class="nav-link text-warning fw-bold px-3" href="cadastrar.php">+ Cadastrar Fruta</a>
                </div>
                <div class="navbar-nav">
                    <a class="nav-link btn btn-outline-light btn-sm px-3 text-white" href="#">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-secondary font-monospace">Gerenciamento de Estoque</h2>
            <span class="badge bg-success p-2">Painel Ativo</span>
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
                            while($fruta = mysqli_fetch_assoc($resultado)) {
                                echo "<tr>";
                                echo "<td>" . $fruta['id'] . "</td>";
                                echo "<td><strong>" . $fruta['nome_fruta'] . "</strong></td>";
                                echo "<td>R$ " . number_format($fruta['preco_quilo'], 2, ',', '.') . "</td>";
                                echo "<td>" . $fruta['quantidade_estoque'] . " kg</td>";
                                echo "<td class='text-center'>
                                        <a href='#' class='btn btn-sm btn-info text-white me-1'>Detalhes</a>
                                        <a href='#' class='btn btn-sm btn-warning me-1'>Editar</a>
                                        <a href='#' class='btn btn-sm btn-danger'>Excluir</a>
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