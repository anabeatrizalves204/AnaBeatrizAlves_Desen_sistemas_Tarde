<?php
// Função para dimensionar a imagem
function redimensionarImagem($imagem, $largura, $altura) {
    // Verifica se o arquivo existe
    if (!file_exists($imagem)) {
        throw new Exception("Arquivo de imagem não encontrado.");
    }

    // Obtém as dimensões originais da imagem
    list($larguraOriginal, $alturaOriginal) = getimagesize($imagem);
    if (!$larguraOriginal || !$alturaOriginal) {
        throw new Exception("Não foi possível obter as dimensões da imagem.");
    }

    // Verifica o tipo de imagem
    $tipoImagem = exif_imagetype($imagem);
    if (!$tipoImagem) {
        throw new Exception("Formato de imagem inválido ou não suportado.");
    }

    // Cria uma nova imagem com as dimensões especificadas
    $novaImagem = imagecreatetruecolor($largura, $altura);
    if (!$novaImagem) {
        throw new Exception("Falha ao criar nova imagem.");
    }

    // Preserva transparência para PNG
    if ($tipoImagem === IMAGETYPE_PNG) {
        imagealphablending($novaImagem, false);
        imagesavealpha($novaImagem, true);
        $transparente = imagecolorallocatealpha($novaImagem, 0, 0, 0, 127);
        imagefilledrectangle($novaImagem, 0, 0, $largura, $altura, $transparente);
    }

    // Cria uma nova imagem a partir do arquivo original
    switch ($tipoImagem) {
        case IMAGETYPE_JPEG:
            $imagemOriginal = imagecreatefromjpeg($imagem);
            break;
        case IMAGETYPE_PNG:
            $imagemOriginal = imagecreatefrompng($imagem);
            break;
        default:
            throw new Exception("Formato de imagem não suportado. Use JPEG ou PNG.");
    }

    if (!$imagemOriginal) {
        imagedestroy($novaImagem);
        throw new Exception("Falha ao carregar a imagem original.");
    }

    // Copia e redimensiona a imagem original para a nova imagem
    if (!imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal)) {
        imagedestroy($novaImagem);
        imagedestroy($imagemOriginal);
        throw new Exception("Falha ao redimensionar a imagem.");
    }

    // Inicia a saída em buffer para capturar os dados da imagem
    ob_start();
    if ($tipoImagem === IMAGETYPE_JPEG) {
        imagejpeg($novaImagem, null, 90); // Qualidade 90 para JPEG
    } elseif ($tipoImagem === IMAGETYPE_PNG) {
        imagepng($novaImagem);
    }
    $dadosImagem = ob_get_clean();

    // Libera a memória usada pelas imagens
    imagedestroy($novaImagem);
    imagedestroy($imagemOriginal);

    return ['dados' => $dadosImagem, 'tipo' => $tipoImagem];
}

// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'bd_imagem';
$username = 'root';
$password = '';

try {
    // Cria uma nova instância de PDO para conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
        // Verifica se não houve erro no upload da foto
        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro ao fazer upload da foto: " . $_FILES['foto']['error']);
        }

        // Valida o tipo MIME do arquivo
        $tipoFoto = $_FILES['foto']['type'];
        $tiposPermitidos = ['image/jpeg', 'image/png'];
        if (!in_array($tipoFoto, $tiposPermitidos)) {
            throw new Exception("Tipo de arquivo inválido. Use JPEG ou PNG.");
        }

        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $nomeFoto = $_FILES['foto']['name'];

        // Redimensiona a imagem para 300x400 pixels
        $resultado = redimensionarImagem($_FILES['foto']['tmp_name'], 300, 400);
        $foto = $resultado['dados'];
        $tipoImagem = $resultado['tipo'];
        $tipoFoto = ($tipoImagem === IMAGETYPE_JPEG) ? 'image/jpeg' : 'image/png';

        // Prepara a instrução SQL para inserir os dados do funcionário no banco de dados
        $sql = "INSERT INTO funcionarios (nome, telefone, nome_foto, tipo_foto, foto) VALUES (:nome, :telefone, :nome_foto, :tipo_foto, :foto)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':nome_foto', $nomeFoto);
        $stmt->bindParam(':tipo_foto', $tipoFoto);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

        if ($stmt->execute()) {
            echo "Funcionário cadastrado com sucesso";
        } else {
            echo "Erro ao cadastrar o funcionário";
        }
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Imagens</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Lista de Imagens</h1>
    <!-- Link para listar funcionários -->
    <a href="consultar_funcionario.php">Listar Funcionários</a>
</body>
</html>