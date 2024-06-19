<?php
include "class/conexao.class.php";

$conexao = new Conexao();
$conn = $conexao->getConn();

$id = $_GET['id'];

$sql = "DELETE FROM usuarios WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Usuário excluído com sucesso!";
} else {
    echo "Erro: " . $stmt->error;
}

$stmt->close();
$conn->close();
header("Location: listar.usuarios.php");
exit();
?>