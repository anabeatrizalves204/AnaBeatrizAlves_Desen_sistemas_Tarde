<?php

require_once 'config.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$pdo =  conectarBanco();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Dashboard</title>
</head>
    <style>
        body{font-family: Arial, sans-serif;}
        .header{background: #333; color: white; padding: 10px}
        .menu{margin: 20px 0}
        table {width: 100%; border-collapse:collapse; border: 1px solid #ddd; margin-top: 20px;}
        th, td {border: 1px solid #ddd; padding: 8px; text-align: left;}
        th {background: #f2f2f2;}
    </style> 
<body>
    <div class="header">
        <h1>Bem-vindo, <?=htmlspecialchars($_SESSION['usuario_nome'])?></h1>
        <a href="logout.php"></a>
    </div>
    <div class="menu">
        <a href="relatorio.php">Gera relatório PDF</a>
    </div>
    <h2>Lista de Produtos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Estoque</th>
            <th>Valor Unitario</th>
        </tr>
        <?php
            $stmt = $pdo->query("SELECT * FROM produto");
            while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
                <tr>
                <td><?= $produto['id_produto'] ?></td>
                <td><?= htmlspecialchars($produto['nome_prod']) ?></td>
                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                <td><?= htmlspecialchars($produto['qtde']) ?></td>
                <td>R$ <?= number_format($produto['valor_unit'], 2, ',','.') ?></td>
                </tr>
            <?php endwhile;?>
    </table>
</body>
