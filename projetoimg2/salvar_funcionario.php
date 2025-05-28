<?php
// Função para dimensionar a imagem
function redimensionarImagem($imagem, $largura, $altura)
{
    // Obter largura e altura originais da imagem
    list($larguraOriginal, $alturaOriginal) = getimagesize($imagem);

    // Criar uma nova imagem com as dimensões especificadas
    $novaImagem = imagecreatetruecolor($largura, $altura);

    // Criar imagem a partir do arquivo original (suportando JPEG)
    $imagemOriginal = imagecreatefromjpeg($imagem);

    // Copiar e redimensionar a imagem original para a nova imagem
    imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);

    // Capturar a saída da imagem redimensionada em memória (buffer)
    ob_start();
    imagejpeg($novaImagem);
    $dadosImagem = ob_get_clean();

    // Liberar memória
    imagedestroy($novaImagem);
    imagedestroy($imagemOriginal);

    return $dadosImagem; // Retorna os dados binários da imagem redimensionada
}

// Configurações de conexão com o banco
$host = 'localhost';
$dbname = 'bd_imagem';
$usuario = 'root';
$password = '';

try {
    // Conectar ao banco via PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //RECUPERA TODOS OS FUNCIONARIOS DO BANCO DE DADOS
    $sql = "SELECT id, nome FROM funcionarios";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(); //Executa a instrução
    $funcionarios = $stmt->fetchALL(PDO::FETCH_ASSOC); // Busca todos os resultados com uma matriz associativa 

    //Verifica se foi solicitado a exclusão de formulário
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['excluir_id'])) {
        $excluir_id = $_POST['excluir_id'];
        $sql_excluir = "DELETE FROM funcionarios WHERE id = :id";
        $stmt_excluir->bindParam(':id', $excluir_id, PDO::PARAM_INT);
        $stmt_excluir->execute();

        //Redireciona para evitar o reenvio do formulário
        header("location: " . $_SERVER['PHP_SELF']);
        exit();
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Funcionario</title>
</head>
<body>
    <h1>Consulta de Funcionário</h1>
    <ul>
        <?php foreach ($funcionarios as $funcionario): ?>
        <li>
            <a href="visualizar_funcionario.php?id=<?= $funcionario['id'] ?>"><?= htmlspecialchars($funcionario['nome']) ?></a>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="excluir_id" value="<?= $funcionario['id'] ?>">
                <button type="submit">Excluir</button>
            </form>
        </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>