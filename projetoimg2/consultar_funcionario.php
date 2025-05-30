<?php
$host = 'localhost';
$dbname = 'bd_imagem';
$usuario = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Define o modo de erro do pdo para exceçoes
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_FILES['foto'])) 

$sql = "SELECT id, nome FROM funcionarios";
$stmt = $pdo->prepare($sql);//Prepara a instrução sql para execuçao
$stmt ->execute(); // Executa a instrução SQL
$funcionarios = $stmt-> fetchALL(PDO::FETCH_ASSOC); // Busca todos os resultados como um array associativo
$stmt->bindParam(':nome', $nome);

//verifica se foi solicitado a exclusao de um formulario
if ($$_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_id'])) {
    $excluir_id = $_POST['excluir_id'];
    $sql_excluir = "DELETE FROM funcionarios WHERE id = :id";
    $stmt_excluir = $pdo->prepare($sql_excluir);
    $stmt_excluir->bindParam(':id', $excluir_id, PDO::PARAM_INT);
    
    if ($stmt_excluir->execute()) {
        echo "Funcionário excluído com sucesso!";
    } else {
        echo "Erro ao excluir funcionário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Funcionários</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
        <h1>Gerenciamento de Funcionários</h1>
        
        <!-- Seção de Upload de Foto -->
        <div class="secao">
            <h2>Upload de Foto</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="foto">Selecionar Foto:</label>
                    <input type="file" name="foto" id="foto" accept="image/*" required>
                </div>
                <button type="submit" class="btn-enviar">Enviar Foto</button>
            </form>
        </div>

        <!-- Seção de Lista de Funcionários -->
        <div class="secao">
            <h2>Lista de Funcionários</h2>
            <?php if (!empty($funcionarios)): ?>
                <table class="tabela-funcionarios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($funcionarios as $funcionario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($funcionario['id']); ?></td>
                                <td><?php echo htmlspecialchars($funcionario['nome']); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="excluir_id" value="<?php echo $funcionario['id']; ?>">
                                        <button type="submit" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="sem-dados">Nenhum funcionário encontrado.</p>
            <?php endif; ?>
        </div>

        <!-- Menu de Navegação -->
        <div class="secao">
            <h2>Menu de Navegação</h2>
            <div class="menu">
                <a href="index.php" class="menu-item">Página Inicial</a>
                <a href="cadastro_funcionario.php" class="menu-item">Cadastrar Funcionário</a>
                <a href="consultar_funcionario.php" class="menu-item">Consultar Funcionário</a>
                <a href="visualizar_funcionario.php" class="menu-item">Visualizar Funcionários</a>
            </div>
        </div>
    </div>
</body>
</html>