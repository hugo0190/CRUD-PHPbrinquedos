<?php

$servidor = 'localhost';
$banco = 'loja_brinquedos';
$usuario = 'root';
$senha = '';
$porta = 3306;

try {

    $conexao = new PDO(
        "mysql:host=$servidor;port=$porta;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );

    $conexao->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conexao->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    http_response_code(500);

    exit('Erro ao conectar com o banco de dados.');
}