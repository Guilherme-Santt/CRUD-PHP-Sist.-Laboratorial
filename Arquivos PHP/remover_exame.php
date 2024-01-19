<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
$id = intval($_GET['id']);
include('conexao.php');

$sql_consulta = "SELECT * FROM pacientes_exames WHERE id = '$id'";
$query_consulta = $mysqli->query($sql_consulta);
$c_paciente = $query_consulta->fetch_assoc();
$paciente = $c_paciente['paciente_id'];

// $sql_consulta = "SELECT * FROM pacientes WHERE id = '$paciente'";
// $query_consulta1 = $mysqli->query($sql_consulta);
// $paciente = $query_consulta1->fetch_assoc();
// $pacienteid = $paciente['id'];

if(isset($_POST['remover'])){
    $sql_remover = "DELETE FROM pacientes_exames WHERE id = '$id'";
    $query_remover = $mysqli->query($sql_remover);
    if($query_remover){
        header("location: pacientes.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
    <h1>Deseja remover exame deste paciente?</h1>
        <button name="remover">Sim</button>
        <a href="editar_pacientes"><button>Não</button></a>
    </form>    
</body>
</html>