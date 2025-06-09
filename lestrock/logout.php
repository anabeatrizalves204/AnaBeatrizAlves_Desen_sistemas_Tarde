<?php
session_start();

// Verificar se existe uma sessão ativa
if (isset($_SESSION['usuario_id'])) {
    // Capturar nome do usuário antes de destruir a sessão (para mensagem de despedida)
    $usuario_nome = isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'Usuário';
    
    // Destruir todas as variáveis de sessão
    $_SESSION = array();
    
    // Se for desejado destruir a sessão completamente, também delete o cookie de sessão
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Finalmente, destruir a sessão
    session_destroy();
    
    // Definir mensagem de logout
    $logout_message = "Até logo, " . htmlspecialchars($usuario_nome) . "!";
    $show_message = true;
} else {
    // Se não houver sessão, redirecionar direto para login
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - Let's Rock Disco Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/logout.css"/>
</head>
<body>
    <div class="particles" id="particles"></div>
    
    <div class="logout-container">
        <div class="logout-icon">👋</div>
        
        <h1 class="logout-title">Logout Realizado</h1>
        
        <?php if (isset($show_message) && $show_message): ?>
            <p class="logout-message"><?php echo $logout_message; ?></p>
        <?php endif; ?>
        
        <div class="logout-info">
            <p>Sua sessão foi encerrada com sucesso.</p>
            <p>Obrigado por visitar a <strong>Let's Rock Disco Store</strong>!</p>
            <p>Esperamos vê-lo novamente em breve! 🎵</p>
        </div>
        
        <div class="btn-container">
            <a href="login.php" class="btn btn-primary">Fazer Login Novamente</a>
            <a href="index.php" class="btn btn-secondary">Página Inicial</a>
        </div>
        
        <div class="redirect-info">
            <p>Você será redirecionado para a página de login em <span class="countdown" id="countdown">10</span> segundos...</p>
        </div>
    </div>

    <script src="js/logout.js"></script>
</body>
</html>