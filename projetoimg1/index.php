<?php
//Inclui o arquivo de conexão com o banco de dados
require_once ('conecta.php');

//Cria a consulta sql para selecionar os dados principais, sem a coluna imagem

$querySelecao = "SELECT codigo, evento, descricao, nome_imagem, tamanho_imagem FROM tabela_imagem";
$resultado = mysqli_query($conexao,$querySelecao);

if (!$resultado){
    die("Erro na consulta: ".mysql_error($conexao));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Armazenamento imagens no banco de dados</title>
</head>
<body>
    <h2>Selecione um novo arquivo de imagem</h2>

    <form enctype="multipart/form-data" action="upload.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>
        <input name="evento" type="text" placeholder="Nome do Evento"/>
        <input name="descricao" type="text" placeholder="Descrição"/>
        <input name="imagem" type="file"/>
        <input type="submit" name="Salvar"/>
    </form>
    <br>

    <table border="1">
        <tr>
            <td align="center">Codigo</td>
            <td align="center">Evento</td>
            <td align="center">Descrição</td>
            <td align="center">Nome da imagem</td>
            <td align="center">Tamanho</td>
            <td align="center">Visualizar imagem</td>
            <td align="center">Excluir imagem</td>
        </tr>
        <?php
            while($arquivos = mysqli_fetch_array($resultado)){?>
            <tr>
                <td align="center"><?php echo $arquivos['codigo'];?></td>
                <td align="center"><?php echo $arquivos['evento'];?></td>
                <td align="center"><?php echo $arquivos['descricao'];?></td>
                <td align="center"><?php echo $arquivos['nome_imagem'];?></td>
                <td align="center"><?php echo $arquivos['tamanho_imagem'];?></td>
                <td align="center"><a href="ver_imagens.php?id="<?php echo $arquivos['codigo'];?>>Ver imagens</a></td>
                <td align="center"><a href="excluir_imagem.php?id="<?php echo $arquivos['codigo'];?>>Excluir</a></td>
            </tr>
            <?php } ?>
    </table>
    
</body>
</html>