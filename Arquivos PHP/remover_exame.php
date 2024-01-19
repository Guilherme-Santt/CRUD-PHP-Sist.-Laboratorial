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
$exame = $c_paciente['exame_id'];


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
    <title>Remover exame do paciente</title>
    <link rel="stylesheet" href="../Arquivos CSS/button.css">
    <link rel="stylesheet" href="../Arquivos CSS/efeito_a.css">

</head>
<body>
    <?php
$sql_consulta = "SELECT descricao FROM exames WHERE exameid = '$exame'";
$query_exame = $mysqli->query($sql_consulta);
$consulta_exame = $query_exame->fetch_assoc();
$nomeex = $consulta_exame['descricao']
    ?>
    <form method="post">
    <h1>Deseja remover exame(<?php echo $nomeex?>) deste paciente?</h1>
        <button name="remover">Sim</button>
        <a href="pacientes.php">Não</a>
    </form>
</body>
</html>