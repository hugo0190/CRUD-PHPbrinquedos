<?php

require_once __DIR__ . '/public/funcoes.php';

$produtos = [];
$erro = false;

try {

    $produtos = listarProdutos($conexao);

} catch (PDOException $exception) {

    error_log($exception->getMessage());

    $erro = true;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Loja de Brinquedos</title>

</head>

<body>

<h1>Produtos Cadastrados</h1>


<?php if ($erro): ?>

    <p>
        Não foi possível consultar os produtos no momento.
    </p>

<?php endif; ?>


<p>
    <a href="public/cadastrar.php">
        Cadastrar novo produto
    </a>
</p>


<table border="1" cellpadding="8" cellspacing="0">

    <thead>

        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Faixa etária</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Opções</th>
        </tr>

    </thead>

    <tbody>

    <?php if (empty($produtos)): ?>

        <tr>
            <td colspan="6">
                Nenhum produto encontrado.
            </td>
        </tr>

    <?php else: ?>

        <?php foreach ($produtos as $produto): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($produto['nome']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($produto['categoria']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($produto['faixa_etaria']) ?>
                </td>

                <td>
                    R$
                    <?= number_format($produto['preco'], 2, ',', '.') ?>
                </td>

                <td>
                    <?= (int)$produto['estoque'] ?>
                </td>

                <td>

                    <a href="public/editar.php?id=<?= $produto['id'] ?>">
                        Editar
                    </a>

                    |

                    <a
                        href="public/excluir.php?id=<?= $produto['id'] ?>"
                        onclick="return confirm('Deseja realmente excluir este produto?')"
                    >
                        Excluir
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    <?php endif; ?>

    </tbody>

</table>

</body>
</html>