<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Funcionários</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de Funcionários</h1>
        
        <div class="menu">
            <a href="cadastro_funcionario.php" class="menu-item">
                Cadastrar Funcionário
            </a>
            
            <a href="consultar_funcionario.php" class="menu-item">
                Consultar Funcionário
            </a>
            
            <a href="salvar_funcionario.php" class="menu-item">
                Salvar Funcionário
            </a>
            
            <a href="visualizar_funcionario.php" class="menu-item">
                Visualizar Funcionários
            </a>
        </div>
        
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> Sistema de Gerenciamento de Funcionários</p>
        </div>
    </div>
</body>
</html>