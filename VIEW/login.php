<?php
// VIEW/login.php
require_once "../DAL/conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuario = verificarLogin($conexao, $email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nome']   = $usuario['nome'];
        $_SESSION['usuario_perfil'] = $usuario['perfil'];

        header("Location: index.php");
        exit;
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IL FRUTTETO DI FAMIGLIA - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px;">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold text-success mb-2">IL FRUTTETO DI FAMIGLIA</h3>
                <p class="text-center text-muted small mb-4">Painel de Controle</p>

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger p-2 text-center small"><?php echo $erro; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-secondary">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="seu@email.com">
                    </div>

                    <div class="mb-4">
                        <label for="senha" class="form-label small fw-bold text-secondary">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required placeholder="••••••">
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">Entrar</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
