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

    $produto = encontrarProduto($conexao, $id);

} catch (PDOException $erro) {

    error_log($erro->getMessage());

    exit('Não foi possível carregar o produto.');
}


if (!$produto) {
    exit('Produto não encontrado.');
}


$mensagens = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = $_POST;

    $mensagens = validarProduto($dados);

    if (empty($mensagens)) {

        try {

            if (atualizarProduto($conexao, $id, $dados)) {
                header('Location: ../index.php');
                exit;
            }

            $mensagens[] = 'Não foi possível atualizar o produto.';

        } catch (PDOException $erro) {

            error_log($erro->getMessage());

            $mensagens[] = 'Erro ao atualizar os dados.';
        }
    }

    $produto = array_merge($produto, $dados);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>

<body>

<h1>Editar Produto</h1>

<?php if (!empty($mensagens)): ?>

    <ul>
        <?php foreach ($mensagens as $mensagem): ?>
            <li><?= htmlspecialchars($mensagem) ?></li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>


<form method="POST">

    <label>
        Nome:
        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($produto['nome']) ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Categoria:
        <input
            type="text"
            name="categoria"
            value="<?= htmlspecialchars($produto['categoria']) ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Faixa etária:
        <input
            type="text"
            name="faixa_etaria"
            value="<?= htmlspecialchars($produto['faixa_etaria']) ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Preço:
        <input
            type="number"
            step="0.01"
            name="preco"
            value="<?= htmlspecialchars($produto['preco']) ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Estoque:
        <input
            type="number"
            name="estoque"
            value="<?= htmlspecialchars($produto['estoque']) ?>"
            required
        >
    </label>

    <br><br>

    <button type="submit">Salvar alterações</button>

</form>

<p>
    <a href="../index.php">Voltar</a>
</p>

</body>
</html>