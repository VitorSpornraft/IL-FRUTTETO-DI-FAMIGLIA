<?php
// VIEW/lotes/cadastrar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

require_once "../../DAL/conexao.php";

$sql_produtos = "SELECT id, nome_fruta, quantidade_estoque FROM produtos";
$produtos = mysqli_query($conexao, $sql_produtos);

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade_entrada'];

    if ($quantidade <= 0) {
        $erro = "A quantidade de entrada deve ser maior do que zero!";
    } else {
        if (inserirLote($conexao, $produto_id, $quantidade)) {
            header("Location: index.php");
            exit;
        } else {
            $erro = "Erro ao registrar a entrada do lote no banco.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA - Novo Lote</title>
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
                <h4 class="mb-0 fs-5">Lançar Nova Entrada (Colheita)</h4>
            </div>
            <div class="card-body p-4">
                
                <?php if(!empty($erro)): ?>
                    <div class="alert alert-danger p-2 text-center small"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form action="cadastrar.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="produto_id" class="form-label fw-bold text-secondary">Fruta Produzida</label>
                        <select class="form-select" id="produto_id" name="produto_id" required>
                            <option value="">-- Selecione a Fruta --</option>
                            <?php 
                            while($prod = mysqli_fetch_assoc($produtos)) {
                                echo "<option value='" . $prod['id'] . "'>" . $prod['nome_fruta'] . " (Estoque atual: " . number_format($prod['quantidade_estoque'], 2, ',', '.') . "kg)</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantidade_entrada" class="form-label fw-bold text-secondary">Quantidade da Colheita / Entrada (KG)</label>
                        <input type="number" step="0.01" class="form-control" id="quantidade_entrada" name="quantidade_entrada" required placeholder="0.00">
                        <div class="form-text text-muted">Este valor será SOMADO diretamente ao estoque atual da fruta.</div>
                    </div>

                    <hr class="text-muted my-4">

                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-outline-secondary px-4">Voltar</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Somar ao Estoque</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>
</html>