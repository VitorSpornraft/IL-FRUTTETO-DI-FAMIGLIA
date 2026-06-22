<?php
//VIEW/excluir.php

require_once "../DAL/conexao.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    excluirFruta($conexao, $id);
}

header("Location: index.php");
exit;

?>