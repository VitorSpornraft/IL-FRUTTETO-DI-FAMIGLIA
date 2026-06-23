<?php
// VIEW/vendas/excluir.php
require_once "../../DAL/conexao.php";

if (isset($_GET['id'])) {
    excluirVenda($conexao, $_GET['id']);
}
header("Location: index.php");
exit;
?>
