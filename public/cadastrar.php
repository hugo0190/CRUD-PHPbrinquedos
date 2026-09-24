<?php

require_once __DIR__ . '/funcoes.php';

$mensagens = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados = $_POST;

    $mensagens = validarProduto($dados);

    if (count($mensagens) === 0) {

        try {

            if (inserirProduto($conexao, $dados)) {
                header('Location: ../index.php');
                exit;
            }

            $mensagens[] = 'Não foi possível realizar o cadastro.';

        } catch (PDOException $erro) {

            error_log($erro->getMessage());

            $mensagens[] = 'Ocorreu um erro ao salvar os dados.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Novo Produto</title>
</head>

<body>

<h1>Cadastrar Produto</h1>

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
            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Categoria:
        <input
            type="text"
            name="categoria"
            value="<?= htmlspecialchars($_POST['categoria'] ?? '') ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Faixa etária:
        <input
            type="text"
            name="faixa_etaria"
            value="<?= htmlspecialchars($_POST['faixa_etaria'] ?? '') ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Preço:
        <input
            type="number"
            name="preco"
            step="0.01"
            value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>"
            required
        >
    </label>

    <br><br>

    <label>
        Estoque:
        <input
            type="number"
            name="estoque"
            value="<?= htmlspecialchars($_POST['estoque'] ?? '') ?>"
            required
        >
    </label>

    <br><br>

    <button type="submit">Cadastrar</button>

</form>

<p>
    <a href="../index.php">Voltar para a lista</a>
</p>

</body>
</html>