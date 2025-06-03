<?php
$mensagem = '';
$erro = '';

// Para debug - remover em produção
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    
    if (empty($nome) || empty($email)) {
        $erro = 'Nome e email são obrigatórios!';
    } else {
        $mensagem = 'Dados recebidos: ' . $nome . ' - ' . $email;
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
            <img src="imagens/logo.png" alt="Logo da página" title="Logo da página">
        </div>
    </header>

    <div class="container">
        <div class="contact-info">
            <h2 class="contact-title">Qualquer dúvida ou sugestão nos contate</h2>
            <div class="contact-email">
                <a href="mailto:contato@letsrock.com">LETSROCKDISOSTORE@GMAIL.COM</a>
            </div>
        </div>

        <div class="form-container">
            <h2 class="form-title">CADASTRO</h2>
            
            <?php if ($mensagem): ?>
                <div class="mensagem sucesso"><?php echo htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="mensagem erro"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            
            <form id="cadastroForm" method="POST" action="">
                <div class="form-group">
                    <input type="text" name="nome" class="form-input" placeholder="Seu nome" 
                           value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <input type="text" name="nascimento" class="form-input" placeholder="Nascimento: DD/MM/AAAA" 
                           value="<?php echo isset($nascimento) ? htmlspecialchars($nascimento) : ''; ?>" 
                           pattern="\d{2}/\d{2}/\d{4}" title="Use o formato DD/MM/AAAA" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-input" placeholder="E-mail" 
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="telefone" class="form-input" placeholder="Número de Telefone" 
                           value="<?php echo isset($telefone) ? htmlspecialchars($telefone) : ''; ?>" required>
                </div>
                <button type="submit" class="submit-btn">CADASTRAR</button>
            </form>
        </div>

        <div class="social-section">
            <h2 class="social-title">NOS ACOMPANHE EM NOSSAS<br>REDES SOCIAIS</h2>
            <div class="social-icons">
                <a href="https://instagram.com/letsrock_discostore" class="social-icon">@</a>
                <a href="https://x.com/letsrock_ds" class="social-icon">X</a>
            </div>
        </div>
    </div>
   
</body>
</html>