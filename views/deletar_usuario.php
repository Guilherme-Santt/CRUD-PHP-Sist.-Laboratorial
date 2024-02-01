<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="../index_login/login.php">Clique aqui para logar</a>');
    }    
}

include('../conexao/conexao.php');
$id = intval($_GET['id']);
if(isset($_POST['confirmar'])){ 
    // REMOVER USUARIO PUXANDO ID DO GET
    $sql_code = "DELETE FROM clientes WHERE id = '$id'";
    $query_code = $mysqli->query($sql_code) or die($mysqli->error);    
        if($query_code) {?> 
            <h1>Usuário removido com sucesso!</h1>
            <a href="../index_usuarios/usuarios.php">Clique aqui   </a> para retornar a listagem de usuários</a>
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

<body>
    <form action="" method="POST">
        <h1>Remover usuário: <?php echo $consulta['nome'] ?> ?</h1>
        <a href="../index_usuarios/usuarios.php">Não!</a>
        <Button name="confirmar" type="submit">Sim!</Button>
    </form>
</body>
</html>