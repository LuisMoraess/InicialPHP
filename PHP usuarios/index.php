<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Gerenciamento de Usuários</title>
</head>
<body>
    <h2>Criação de Usuário</h2>
    <form action="inserir.usuario.php" method="post">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div>
            <input type="submit" value="Criar Usuário">
        </div>
    </form>
    <hr>
    <h2>Gerenciar Usuários</h2>
    <a href="listar.usuarios.php">Listar Usuários</a>
</body>
</html>