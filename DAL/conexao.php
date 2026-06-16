<?php
// DAL/conexao.php - Arquivo de Conexão Completo

$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "hortifruti_db";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

function inserirFruta($conexao, $nome, $preco, $estoque) {
    
    $sql = "INSERT INTO produtos (nome_fruta, preco_quilo, quantidade_estoque) 
            VALUES ('$nome', '$preco', '$estoque')";
            
    return mysqli_query($conexao, $sql);
    
} 
?>