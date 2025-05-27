<?php
session_start();
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca o usuário pelo email
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Login bem-sucedido, define variáveis de sessão
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['id_perfil'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];

        // Verifica se a senha é temporária
        if ($usuario['senha_temporaria']) {
            // Redireciona para a troca de senha
            header("Location: alterar_senha.php");
            exit();
        } else {
            // Redireciona para a página principal
            header("Location: principal.php");
            exit();
        }
    } else {
        // Login inválido
        echo "<script>alert('E-mail ou senha incorretos.'); window.location.href='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Let's Rock Disco Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="particles" id="particles"></div>
    
    <header class="header">
        <div class="header-content">
            <h1 class="main-title">CADASTRE-SE E DIVIRTA-SE</h1>
            <img src="imagens/letsrock.png" alt="Logo da página" title="Logo da página">
            <!-- <div class="logo"> 
                <div class="vinyl-record">
                    <div class="vinyl-center"></div>
                    <img src="imagens/letsrock.png" alt="Logo da página" title="Logo da página">

                </div>
                <div class="logo-text">
                </div>
            </div>
        </div>-->
    </header>

    <div class="container">
        <div class="contact-info">
            <h2 class="contact-title">Qualquer dúvida ou sugestão nos contate</h2>
            <div class="contact-email">LETSROCKDISOSTORE@GMAIL.COM</div>
        </div>

        <div class="form-container">
            <h2 class="form-title">CADASTRO</h2>
            <form id="cadastroForm">
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Seu nome" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Nascimento: DD/MM/AAAA" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-input" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <input type="tel" class="form-input" placeholder="Número de Telefone" required>
                </div>
                <button type="submit" class="submit-btn">CADASTRAR</button>
            </form>
        </div>

        <div class="social-section">
            <h2 class="social-title">NOS ACOMPANHE EM NOSSAS<br>REDES SOCIAIS</h2>
            <div class="social-icons">
                <a href="#" class="social-icon">@</a>
                <a href="#" class="social-icon">X</a>
            </div>
        </div>
    </div>

   
</body>
</html>