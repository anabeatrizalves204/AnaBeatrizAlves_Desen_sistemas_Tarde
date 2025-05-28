<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <h2>Formulário</h2>

<!--FORMULÁRIO PARA CADASTRAR FUNCIONÁRIO-->
    <form action="salvar_funcionario.php" method="POST" enctype="multipart/form-data">
<!-- CAMPO PARA INSERIR NOME DO FUNCIONARIO -->
        <label for="nome">Nome: </label>
        <input type="text" name="nome" id="nome" required><br>

        <label for="telefone">Telefone: </label>
        <input type="text" name="telefone" id="telefone" required><br>

    <!-- CAMPO PARA FAZER UPLOAD DA FOTO -->
        <label for="foto">Foto: </label>
        <input type="file" name="foto" id="foto" required><br>

    <!-- BOTÃO PARA ENVIAR O FORMULÁRIO -->
        <button type="submit">Cadastrar</button>
    </form>
    </div>
</body>
</html>