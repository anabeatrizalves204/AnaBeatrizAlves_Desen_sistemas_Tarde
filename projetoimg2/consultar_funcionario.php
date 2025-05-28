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

    // Verifica se o formulário foi enviado via POST e a imagem foi carregada
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
        if ($_FILES['foto']['error'] == 0) {
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $nome_foto = $_FILES['foto']['name'];
            $tipo_foto = $_FILES['foto']['type'];

            // Redimensionar a imagem para 300x400
            $foto = redimensionarImagem($_FILES['foto']['tmp_name'], 300, 400);

            // Preparar comando SQL para inserir dados no banco
            $sql = "INSERT INTO funcionarios (nome, telefone, nome_foto, tipo_foto, foto) VALUES (:nome, :telefone, :nome_foto, :tipo_foto, :foto)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':nome_foto', $nome_foto);
            $stmt->bindParam(':tipo_foto', $tipo_foto);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

            if ($stmt->execute()) {
                echo "Funcionário cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar funcionário.";
            }
        } else {
            echo "Erro no upload da foto! Código: " . $_FILES['foto']['error'];
        }
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Imagens</title>
</head>

<body>
    <h1>Lista de Imagens</h1>
    <!-- Link para listar funcionarios -->
    <a href="consultar_funcionario.php">Listar Funcionarios</a>

</body>

</html>