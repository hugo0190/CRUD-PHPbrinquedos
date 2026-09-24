<?php

require_once __DIR__ . '/../infra/conexao.php';


function listarProdutos($conexao)
{
    $sql = "
        SELECT id, nome, categoria, faixa_etaria, preco, estoque
        FROM produtos
        ORDER BY nome ASC
    ";

    $consulta = $conexao->prepare($sql);
    $consulta->execute();

    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}


function encontrarProduto($conexao, $id)
{
    $consulta = $conexao->prepare(
        "SELECT * FROM produtos WHERE id = ?"
    );

    $consulta->execute([$id]);

    return $consulta->fetch(PDO::FETCH_ASSOC);
}


function validarProduto($dados)
{
    $erros = [];

    $campos = [
        'nome' => 100,
        'categoria' => 50,
        'faixa_etaria' => 30
    ];

    foreach ($campos as $campo => $limite) {

        $valor = $dados[$campo] ?? '';

        if (!is_string($valor) || trim($valor) === '') {

            $nomeCampo = ucfirst(str_replace('_', ' ', $campo));

            $erros[] = "$nomeCampo deve ser preenchido.";

        } elseif (mb_strlen(trim($valor), 'UTF-8') > $limite) {

            $nomeCampo = ucfirst(str_replace('_', ' ', $campo));

            $erros[] = "$nomeCampo pode ter no máximo $limite caracteres.";
        }
    }


    $preco = $dados['preco'] ?? '';

    if (
        !is_numeric($preco) ||
        $preco < 0
    ) {
        $erros[] = 'Informe um preço válido.';
    }


    $estoque = $dados['estoque'] ?? '';

    if (
        filter_var($estoque, FILTER_VALIDATE_INT) === false ||
        (int)$estoque < 0
    ) {
        $erros[] = 'O estoque precisa ser um número inteiro maior ou igual a zero.';
    }


    return $erros;
}


function inserirProduto($conexao, $dados)
{
    $sql = "
        INSERT INTO produtos
        (nome, categoria, faixa_etaria, preco, estoque)
        VALUES (?, ?, ?, ?, ?)
    ";

    $consulta = $conexao->prepare($sql);

    return $consulta->execute([
        trim($dados['nome']),
        trim($dados['categoria']),
        trim($dados['faixa_etaria']),
        $dados['preco'],
        $dados['estoque']
    ]);
}


function atualizarProduto($conexao, $id, $dados)
{
    $sql = "
        UPDATE produtos
        SET nome = ?,
            categoria = ?,
            faixa_etaria = ?,
            preco = ?,
            estoque = ?
        WHERE id = ?
    ";

    $consulta = $conexao->prepare($sql);

    return $consulta->execute([
        trim($dados['nome']),
        trim($dados['categoria']),
        trim($dados['faixa_etaria']),
        $dados['preco'],
        $dados['estoque'],
        $id
    ]);
}


function apagarProduto($conexao, $id)
{
    $consulta = $conexao->prepare(
        "DELETE FROM produtos WHERE id = ?"
    );

    return $consulta->execute([$id]);
}