<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }
}

$id = intval($_GET['id']);
include('../conexao/conexao.php');

if(isset($_POST['remover'])){
    $sql_remover = "DELETE FROM pacientes_exames WHERE id = '$id'";
    $query_remover = $mysqli->query($sql_remover);
    if($query_remover){
        header("location: ../index_pacientes/pacientes.php");
    }
}

?>
<?php
// CONSULTA TABELA PACIENTES_EXAMES PARA VERIFICAR O EXAME DO PACIENTE ATRAVÉS DO ID DO RELACIONAMENTO
$sql_consulta = "SELECT * FROM pacientes_exames WHERE id = '$id'";
$query_consulta = $mysqli->query($sql_consulta);
$c_paciente = $query_consulta->fetch_assoc();
$paciente = $c_paciente['paciente_id'];
$exame = $c_paciente['exame_id'];
// CONSULTA PARA VERIFICAR NOME ATRAVÉS DO ID PUXADO NA CONSULTA PACIENTES EXAMES
$sql_consulta = "SELECT descricao FROM exames WHERE exameid = '$exame'";
$query_exame = $mysqli->query($sql_consulta);
$consulta_exame = $query_exame->fetch_assoc();
$nomeex = $consulta_exame['descricao']
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Roboto+Condensed:ital,wght@1,200;1,300;1,400&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remover exame do paciente</title>
    <link rel="stylesheet" href="../Arquivos CSS/button.css">
    <link rel="stylesheet" href="../Arquivos CSS/efeito_a.css">

</head>
<body>
    <form method="post">
    <h1>Deseja remover exame(<?php echo $nomeex?>) deste paciente?</h1>
        <button  name="remover">Sim</button>
        <a href="editar_paciente.php?id=<?php echo $paciente ?>">Não</a>
    </form>
</body>
</html>