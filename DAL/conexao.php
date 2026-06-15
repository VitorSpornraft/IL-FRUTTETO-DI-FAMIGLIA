<?php
//DAL/conexao.php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "hortifruti_db";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

?>