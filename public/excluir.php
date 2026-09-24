<?php

require_once __DIR__ . '/funcoes.php';

$id = $_GET['id'] ?? 0;

if (
    !is_scalar($id) ||
    filter_var($id, FILTER_VALIDATE_INT) === false ||
    (int)$id <= 0
) {
    header('Location: ../index.php');
    exit;
}

try {

    apagarProduto($conexao, $id);

} catch (PDOException $erro) {

    error_log($erro->getMessage());
}

header('Location: ../index.php');
exit;