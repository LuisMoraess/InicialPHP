<?php
include "class/conexao.class.php";

$conexao = new Conexao();
$conn = $conexao->getConn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Nova senha digitada pelo usuário

    // Verifica se foi digitada uma nova senha
    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT); // Hash da nova senha
        // Atualiza os dados incluindo a senha
        $sql = "UPDATE usuarios SET nome=?, email=?, senha=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $email, $senha_hash, $id);
    } else {
        // Atualiza os dados sem alterar a senha
        $sql = "UPDATE usuarios SET nome=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nome, $email, $id);
    }

    if ($stmt->execute()) {
        echo "Usuário atualizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: listar.usuarios.php");
    exit();
} else {
    // Obtém os dados do usuário a partir do ID
    $id = $_GET['id'];

    $sql = "SELECT nome, email FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($nome, $email);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style2.css">
            <title>Editar Usuário</title>
        </head>
        <body>
            <h2>Editar Usuário</h2>
            <form action="editar.usuario.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                </div>
                <div>
                    <label for="senha">Nova Senha:</label>
                    <input type="password" id="senha" name="senha">
                    <span>Deixe em branco para manter a senha atual.</span>
                </div>
                <div>
                    <input type="submit" value="Atualizar Usuário">
                </div>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Usuário não encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>