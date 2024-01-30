<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}

include('../conexao/conexao.php');
$id = intval($_GET['id']);
if(isset($_POST['confirmar'])){ 
    // DELETANDO O ID DO PACIENTE PUXANDO O ID NO GET
    $sql_code = "DELETE FROM pacientes WHERE id = '$id'";
    $query_code = $mysqli->query($sql_code) or die($mysqli->error);
        if($query_code) {?> 
            <h1>Paciente removido com sucesso!</h1>
            <p><a href="pacientes.php">Clique aqui </a>para retornar a listagem de pacientes</p>
            <?php
            die();
        }
} 
// CONSULTA NA TABELA PACIENTES, PUXANDO O CAMPO NOME, PARA O H1 NO FORM 
include('../conexao/conexao.php');
$id = intval($_GET['id']);
$consult_code = "SELECT * FROM pacientes WHERE id = '$id'";
$consult_query = $mysqli->query($consult_code);
$consulta = $consult_query->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar paciente</title>
</head>
<body>
    <form action="" method="POST">
        <h1>Remover paciente: <?php echo $consulta['nome']; ?> ?</h1>
        <a href="pacientes.php">Não!</a>
        <Button name="confirmar" type="submit">Sim!</Button>
    </form>
</body>
</html>