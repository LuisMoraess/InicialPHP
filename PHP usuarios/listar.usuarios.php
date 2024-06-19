<?php
include "class/conexao.class.php";

// Instancia a classe de conexão
$conexao = new Conexao();
$conn = $conexao->getConn();

// Query para selecionar todos os usuários
$sql = "SELECT id, nome, email FROM usuarios";
$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Início da tabela HTML
    echo "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='css/style3.css'>
                <title>Lista de Usuários</title>
            </head>
            <body>
                <div class='container'>
                    <h2>Lista de Usuários</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>";

    // Loop para mostrar cada usuário na tabela
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["nome"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>
                    <a href='editar.usuario.php?id=" . $row["id"] . "' class='btn btn-editar'>Editar</a>
                    <a href='excluir.usuario.php?id=" . $row["id"] . "' class='btn btn-excluir' onclick=\"return confirm('Tem certeza que deseja excluir este usuário?');\">Excluir</a>
                </td>
              </tr>";
    }

    // Fechamento da tabela e do HTML
    echo "</tbody>
          </table>
          <a href='index.php' class='btn btn-voltar'>Voltar</a>
          </div>
          </body>
          </html>";
} else {
    // Caso não haja usuários encontrados
    echo "<!DOCTYPE html>
            <html lang='pt-BR'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' href='css/style3.css'>
                <title>Nenhum Usuário Encontrado</title>
            </head>
            <body>
                <div class='container'>
                    <h2>Nenhum Usuário Encontrado</h2>
                    <p>Não há usuários cadastrados.</p>
                    <a href='index.php' class='btn btn-voltar'>Voltar</a>
                </div>
            </body>
            </html>";
}

// Fecha a conexão
$conn->close();
?>