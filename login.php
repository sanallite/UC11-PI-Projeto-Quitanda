<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada - Quitandão Senac</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="login">
    <header>
        <a href="index.php"><img src="Layout/logoquitanda-01 1.png" alt="Logotipo Quitandão"></a>
    </header>

    <main class="login">
        <form action="processa_login.php" method="post">
            <h2>Entrada de administradores</h2>

            <label for="nome_us">Nome de usuário:</label>
            <input type="text" name="nome_us" id="nome_us">

            <label for="senha_us">Senha:</label>
            <input type="text" name="senha_us" id="nome_us">

            <input type="submit" value="Entrar" name="entrar">
        </form>
    </main>
</body>
</html>