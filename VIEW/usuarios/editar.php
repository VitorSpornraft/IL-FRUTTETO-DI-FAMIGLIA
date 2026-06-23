<?php
// VIEW/usuarios/editar.php
require_once "../../DAL/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id    = $_POST['id'];
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (atualizarUsuario($conexao, $id, $nome, $email, $senha)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<div class='alert alert-danger mb-0 rounded-0'>Erro ao atualizar usuário!</div>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = buscarUsuarioPorId($conexao, $id);
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
    <title>IL FRUTTETO DI FAMIGLIA - Editar Usuário</title>
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
                <h4 class="mb-0 fs-5">Alterar Dados do Usuário</h4>
            </div>
            <div class="card-body p-4">

                <form action="editar.php" method="POST">

                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                    <div class="mb-3">
                        <label for="nome" class="form-label fw-bold text-secondary">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="<?php echo $user['nome']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-secondary">E-mail (Login)</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo $user['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label fw-bold text-secondary">Nova Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha"
                            placeholder="Deixe em branco para manter a senha atual">
                        <div class="form-text text-muted">Só preencha se quiser mudar a senha do usuário.</div>
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
