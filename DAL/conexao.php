<?php
// DAL/conexao.php

$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "hortifruti_db";

$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

function inserirFruta($conexao, $nome, $preco, $estoque)
{

    $sql = "INSERT INTO produtos (nome_fruta, preco_quilo, quantidade_estoque) 
            VALUES ('$nome', '$preco', '$estoque')";

    return mysqli_query($conexao, $sql);
}

function excluirFruta($conexao, $id)
{

    $sql = "DELETE FROM produtos WHERE id = $id";

    return mysqli_query($conexao, $sql);
}

function buscarFrutaPorId($conexao, $id)
{
    $sql = "SELECT * FROM produtos WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);

    return mysqli_fetch_assoc($resultado);
}

function atualizarFruta($conexao, $id, $nome, $preco, $estoque)
{
    $sql = "UPDATE produtos SET 
            nome_fruta = '$nome', 
            preco_quilo = '$preco', 
            quantidade_estoque = '$estoque' 
            WHERE id = $id";

    return mysqli_query($conexao, $sql);
}

function buscarResumoEstoque($conexao)
{
    $sql = "SELECT
                COUNT(*) as total_especies,
                SUM(quantidade_estoque) as total_quilos,
                SUM(preco_quilo * quantidade_estoque) as valor_total
            FROM produtos";

    $resultado = mysqli_query($conexao, $sql);
    return mysqli_fetch_assoc($resultado);
}
