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

function listarUsuarios($conexao)
{
    $sql = "SELECT id, nome, email FROM usuarios";
    return mysqli_query($conexao, $sql);
}

function inserirUsuario($conexao, $nome, $email, $senha)
{
    $senhaCripto = md5($senha);
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaCripto')";
    return mysqli_query($conexao, $sql);
}

function buscarUsuarioPorId($conexao, $id)
{
    $sql = "SELECT id, nome, email FROM usuarios WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql);
    return mysqli_fetch_assoc($resultado);
}

function atualizarUsuario($conexao, $id, $nome, $email, $senha = null)
{
    if (!empty($senha)) {
        $senhaCripto = md5($senha);
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senhaCripto' WHERE id = $id";
    } else {
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email' WHERE id = $id";
    }
    return mysqli_query($conexao, $sql);
}

function excluirUsuario($conexao, $id)
{
    $sql = "DELETE FROM usuarios WHERE id = $id";
    return mysqli_query($conexao, $sql);
}

function listarVendas($conexao)
{
    $sql = "SELECT v.id, p.nome_fruta, v.quantidade_vendida, v.valor_total, v.data_venda
            FROM vendas v
            INNER JOIN produtos p ON v.produto_id = p.id
            ORDER BY v.data_venda DESC";
    return mysqli_query($conexao, $sql);
}

function inserirVenda($conexao, $produto_id, $quantidade, $valor_total)
{
    $sql_venda = "INSERT INTO vendas (produto_id, quantidade_vendida, valor_total)
            VALUES ($produto_id, $quantidade, $valor_total)";

    if (mysqli_query($conexao, $sql_venda)) {
        $sql_estoque = "UPDATE produtos
                        SET quantidade_estoque = quantidade_estoque - $quantidade
                        WHERE id = $produto_id";

        return mysqli_query($conexao, $sql_estoque);
    }

    return false;
}

function excluirVenda($conexao, $id)
{
    $sql = "DELETE FROM vendas WHERE id = $id";
    return mysqli_query($conexao, $sql);
}

function verificarLogin($conexao, $email, $senha)
{
    $senhaCripto = md5($senha);
    $emailLimpo = mysqli_real_escape_string($conexao, $email);

    $sql = "SELECT id, nome, email, perfil FROM usuarios WHERE email = '$emailLimpo' AND senha = '$senhaCripto'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        return mysqli_fetch_assoc($resultado);
    }
    return false;
}
