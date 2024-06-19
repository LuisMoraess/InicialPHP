<?php
include "class/conexao.class.php";

// Criar uma instância da classe Conexao
$conexao = new Conexao();
$conn = $conexao->getConn();

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se os campos estão definidos e não estão vazios
    if (isset($_POST['nome'], $_POST['email'], $_POST['senha']) && 
        !empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
        
        // Sanitizar dados de entrada
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); // Usar bcrypt para hash da senha

        // Verificar se a sanitização do email foi bem sucedida
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Verificar se o usuário já existe
            $stmt_verifica = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt_verifica->bind_param("s", $email);
            $stmt_verifica->execute();
            $stmt_verifica->store_result();

            if ($stmt_verifica->num_rows > 0) {
                echo "<!DOCTYPE html>
                        <html lang='pt-BR'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <link rel='stylesheet' href='css/style4.css'>
                            <title>Erro ao Criar Usuário</title>
                        </head>
                        <body>
                            <div class='container'>
                                <h2>Erro ao Criar Usuário</h2>
                                <p>O email fornecido já está em uso.</p>
                                <a href='index.php' class='btn-voltar'>Voltar</a>
                            </div>
                        </body>
                        </html>";
                exit(); // Encerra o script após exibir a mensagem
            }

            // Preparar e vincular para inserção do novo usuário
            $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sss", $nome, $email, $senha);

                if ($stmt->execute()) {
                    echo "<!DOCTYPE html>
                            <html lang='pt-BR'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <link rel='stylesheet' href='css/style4.css'>
                                <title>Usuário Criado</title>
                            </head>
                            <body>
                                <div class='container'>
                                    <h2>Usuário Criado com Sucesso!</h2>
                                    <a href='index.php' class='btn-voltar'>Voltar</a>
                                </div>
                            </body>
                            </html>";
                    exit(); // Encerra o script após exibir a mensagem
                } else {
                    echo "Erro: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Erro ao preparar a declaração: " . $conn->error;
            }
            
            $stmt_verifica->close();
        } else {
            echo "Endereço de e-mail inválido.";
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

$conn->close();
?>