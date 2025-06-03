<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'bd_imagem';
$username = 'root';
$password = '';

try {
    // Cria uma nova instância de PDO para conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Define o modo de erro do PDO para exceções

    // Verifica se o ID foi passado na URL
    if (isset($_GET['id'])) {
        $id = $_GET['id']; // Obtém o ID do funcionário da URL

        // Recupera os dados do funcionário do banco de dados
        $sql = "SELECT nome, telefone, tipo_foto, foto FROM funcionarios WHERE id = :id";
        $stmt = $pdo->prepare($sql); // Prepara a instrução SQL para execução
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Vincula o valor do ID ao parâmetro :id
        $stmt->execute(); // Executa a instrução SQL

        // Verifica se encontrou o funcionário
        if ($stmt->rowCount() > 0) {
            $funcionario = $stmt->fetch(PDO::FETCH_ASSOC); // Busca os dados do funcionário como um array associativo

            // Verifica se foi solicitado a exclusão do funcionário
			// LINHA ABAIXO VERIFICA se os dados foram enviados via formulário com o método POST e
			// isset verifica-se se há um valor definido na variável 
			// Verifica se o formulário foi enviado via POST e se existe o campo 'excluir_id'
			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir_id'])) { 
				// Pega o valor do ID que foi enviado pelo formulário (ID do funcionário a ser excluído)
				$excluir_id = $_POST['excluir_id']; 
				// Monta a query SQL para deletar o funcionário com o ID correspondente
				$sql_excluir = "DELETE FROM funcionarios WHERE id = :id"; 
				// Prepara a query para execução segura, evitando SQL injection
				$stmt_excluir = $pdo->prepare($sql_excluir); 
				// Associa o valor do ID ao parâmetro :id na query, garantindo que será tratado como número inteiro
				$stmt_excluir->bindParam(':id', $excluir_id, PDO::PARAM_INT); 
				// Executa a query, excluindo o funcionário do banco de dados
				$stmt_excluir->execute(); 

                // Redireciona para a página inicial após a exclusão
                header("Location: consulta_funcionario.php");
                exit();
            }
            ?>
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
                <title>Visualizar Funcionário</title> <!-- Título da página -->
                <link rel="stylesheet" href="css/style.css">
            </head>
            <body>
                <h1>Dados do Funcionário</h1> <!-- Cabeçalho da página -->
                <!-- Exibe os dados do funcionário -->
                <p>Nome: <?= htmlspecialchars($funcionario['nome']) ?></p>
                <p>Telefone: <?= htmlspecialchars($funcionario['telefone']) ?></p>
                <p>Foto:</p>
                <img src="data:<?= $funcionario['tipo_foto'] ?>;base64,<?= base64_encode($funcionario['foto']) ?>" alt="Foto do Funcionário"> <!-- Exibe a foto do funcionário -->

                <!-- Formulário para excluir funcionário -->
                <form method="POST">
                    <input type="hidden" name="excluir_id" value="<?= $id ?>">
                    <button type="submit">Excluir Funcionário</button>
                </form>
            </body>
            </html>
            <?php
        } else {
            echo "Funcionário não encontrado."; // Mensagem exibida se o funcionário não for encontrado
        }
    } else {
        echo "ID do funcionário não foi fornecido."; // Mensagem exibida se o ID não for fornecido na URL
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage(); // Exibe a mensagem de erro se a conexão ou a consulta falhar
}
?>