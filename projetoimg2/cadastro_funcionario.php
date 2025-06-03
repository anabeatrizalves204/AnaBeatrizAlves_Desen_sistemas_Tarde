<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Formulario Cadastro</title>
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <h2>Funcionario</h2>

        <!-- FORMULARIO PARA CADASTRAR FUNCIONARIO -->
         <div class="form-wrapper">
            <form action="salvar_funcionario.php" method="POST" enctype="multipart/form-data">


                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <br>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required>
                <br>
                <!-- CAMPO PARA FAZER UPLOAD DE FOTO -->

                <label for="foto">Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
                <br>
                <button type="submit">Cadastrar</button>
            </form> 
         </div>
    </div>
</body>
</html>