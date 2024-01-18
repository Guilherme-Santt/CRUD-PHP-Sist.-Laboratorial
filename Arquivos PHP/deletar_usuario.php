<?php
include('conexao.php');
$id = intval($_GET['id']);
if(isset($_POST['confirmar'])){ 
    // REMOVER USUARIO PUXANDO ID DO GET
    $sql_code = "DELETE FROM clientes WHERE id = '$id'";
    $query_code = $mysqli->query($sql_code) or die($mysqli->error);    
        if($query_code) {?> 
            <h1>Usuário removido com sucesso!</h1>
            <p><a href="usuarios.php">Clique aqui </a>para retornar a listagem de usuários</p>
            <?php
            die();
        }
}
// CONSULTANDO TABELA CLIENTES PARA PUXAR NOME DO USUARIO QUE DESEJA REMOVER
$sql_consult = "SELECT * FROM clientes WHERE id = '$id'";
$query_consult = $mysqli->query($sql_consult);
$consulta = $query_consult->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar usuário</title>
</head>
<link rel="stylesheet" href="../Arquivos CSS/button.css">
<link rel="stylesheet" href="../Arquivos CSS/efeito_a.css">
<body>
    <form action="" method="POST">
        <h1>Remover usuário: <?php echo $consulta['nome'] ?> ?</h1>
        <a href="index.php">Não!</a>
        <Button name="confirmar" type="submit">Sim!</Button>
    </form>
</body>
</html>