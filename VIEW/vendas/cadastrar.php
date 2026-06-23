<?php
// VIEW/vendas/cadastrar.php

require_once "../../DAL/conexao.php";

$sql_produtos = "SELECT id, nome_fruta, preco_quilo, quantidade_estoque FROM produtos";
$produtos = mysqli_query($conexao, $sql_produtos);

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto_id = $_POST['produto_id'];
    $quantidade_solicitada = $_POST['quantidade_vendida'];
    $preco_un  = $_POST['preco_quilo'];

    $produto_id_limpo = mysqli_real_escape_string($conexao, $produto_id);
    $busca_estoque = mysqli_query($conexao, "SELECT nome_fruta, quantidade_estoque FROM produtos WHERE id = $produto_id_limpo");
    $prod_atual = mysqli_fetch_assoc($busca_estoque);

    if (!$prod_atual || $prod_atual['quantidade_estoque'] <= 0) {
        $erro = "Atenção: O estoque de " . $prod_atual['nome_fruta'] . " está totalmente esgotado!";
    } elseif ($quantidade_solicitada > $prod_atual['quantidade_estoque']) {
        $erro = "Estoque insuficiente! Você tentou vender " . number_format($quantidade_solicitada, 2, ',', '.') . " kg, mas restam apenas " . number_format($prod_atual['quantidade_estoque'], 2, ',', '.') . " kg em estoque.";
    } else {
        $valor_total = $quantidade_solicitada * $preco_un;

        if (inserirVenda($conexao, $produto_id, $quantidade_solicitada, $valor_total)) {
            header("Location: index.php");
            exit;
        } else {
            $erro = "Erro interno ao registrar a venda no banco de dados.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA - Registrar Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../index.php">IL FRUTTETO DI FAMIGLIA</a>
        </div>
    </nav>

    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white p-3">
                <h4 class="mb-0 fs-5">Lançar Nova Venda</h4>
            </div>
            <div class="card-body p-4">

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-warning p-3 text-center small fw-bold shadow-sm"><?php echo $erro; ?></div>
                <?php endif; ?>

                <form action="cadastrar.php" method="POST">

                    <div class="mb-3">
                        <label for="produto_id" class="form-label fw-bold text-secondary">Escolha a Fruta</label>
                        <select class="form-select" id="produto_id" name="produto_id" required onchange="atualizarPreco()">
                            <option value="">-- Selecione uma Fruta --</option>
                            <?php
                            while ($prod = mysqli_fetch_assoc($produtos)) {
                                echo "<option value='" . $prod['id'] . "' data-preco='" . $prod['preco_quilo'] . "'>" . $prod['nome_fruta'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" id="preco_quilo" name="preco_quilo" value="">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">Preço por KG</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" class="form-control bg-white" id="preco_tela" disabled placeholder="0,00">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="quantidade_vendida" class="form-label fw-bold text-secondary">Qtd. Vendida (KG)</label>
                            <input type="number" step="0.01" class="form-control" id="quantidade_vendida" name="quantidade_vendida" required placeholder="0.00">
                        </div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary px-4">Voltar</a>
                        <button type="submit" class="btn btn-success px-4 fw-bold">Confirmar Venda</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        function atualizarPreco() {
            var select = document.getElementById('produto_id');
            var option = select.options[select.selectedIndex];
            var preco = option.getAttribute('data-preco');

            if (preco) {
                document.getElementById('preco_tela').value = parseFloat(preco).toFixed(2).replace('.', ',');
                document.getElementById('preco_quilo').value = preco;
            } else {
                document.getElementById('preco_tela').value = '';
                document.getElementById('preco_quilo').value = '';
            }
        }
    </script>

</body>

</html>
