<?php
session_start();
require_once 'conexao.php';

$mensagem = '';
$erro = '';

// Para debug - remover em produção
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se usuário já está logado
if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php'); // Redirecionar para área logada
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    // Validações básicas
    if (empty($email) || empty($senha)) {
        $erro = 'Email e senha são obrigatórios!';
    } else {
        try {
            // Buscar usuário no banco de dados
            $sql = "SELECT id, nome, email, senha_hash FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verificar senha
                if (password_verify($senha, $usuario['senha_hash'])) {
                    // Login bem-sucedido
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nome'] = $usuario['nome'];
                    $_SESSION['usuario_email'] = $usuario['email'];
                    
                    $mensagem = 'Login realizado com sucesso!';
                    
                    // Redirecionar após 2 segundos
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'dashboard.php';
                        }, 2000);
                    </script>";
                } else {
                    $erro = 'Email ou senha incorretos!';
                }
            } else {
                $erro = 'Email ou senha incorretos!';
            }
        } catch(PDOException $e) {
            $erro = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Let's Rock Disco Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/login.css"/>
    <script src="js/login.js" defer></script>
</head>
<body>
    <div class="particles" id="particles"></div>
    
    <header class="header">
        <div class="header-content">
            <h1 class="main-title">FAÇA SEU LOGIN</h1>
            <img src="imagens/logo.png" alt="Logo da página" title="Logo da página">
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2 class="form-title">LOGIN</h2>
            
            <?php if ($mensagem): ?>
                <div class="mensagem sucesso"><?php echo htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="mensagem erro"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            
            <form id="loginForm" method="POST" action="">
                <div class="form-group">
                    <input type="email" name="email" class="form-input" placeholder="E-mail" 
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <input type="password" name="senha" class="form-input" placeholder="Senha" required>
                </div>
                <div class="form-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="lembrar" name="lembrar" class="checkbox-input">
                        <label for="lembrar" class="checkbox-label">Lembrar de mim</label>
                    </div>
                </div>
                <button type="submit" class="submit-btn">ENTRAR</button>
            </form>
            
            <div class="login-links">
                <a href="cadastro.php" class="link">Não tem conta? Cadastre-se</a>
            </div>
        </div>
    </div>
   
</body>
</html>