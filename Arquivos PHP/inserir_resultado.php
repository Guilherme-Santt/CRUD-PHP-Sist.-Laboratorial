<?php
$id = intval($_GET['id']);
include('conexao.php');

// CONSULTA TABELA PACIENTES_EXAMES PARA VERIFICAR O EXAME DO PACIENTE ATRAVÉS DO ID DO RELACIONAMENTO
$sql_consulta = "SELECT * FROM pacientes_exames WHERE id = '$id'";
$query_consulta = $mysqli->query($sql_consulta);
$c_paciente = $query_consulta->fetch_assoc();
$paciente = $c_paciente['paciente_id'];
$exame = $c_paciente['exame_id'];
$result_exame = $c_paciente['resultado'];

// CONSULTA PARA VERIFICAR NOME ATRAVÉS DO ID PUXADO NA CONSULTA PACIENTES EXAMES
$sql_consulta = "SELECT * FROM exames WHERE exameid = '$exame'";
$query_exame = $mysqli->query($sql_consulta);
$consulta_exame = $query_exame->fetch_assoc();
$nomeex = $consulta_exame['codigo'];

if(isset($_POST['result'])){
    $result = $_POST['result'];
    $sql_code = "UPDATE pacientes_exames SET resultado = '$result' WHERE id = '$id'";
    $query = $mysqli->query($sql_code);

    $sucess = "";
    if($query){
        $sucess = "Resultado inserido com sucesso";
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
<link rel="stylesheet" href="../Arquivos CSS/button.css">
<body>

    <a href="pacientes.php"><button class="button1">Retornar a listagem de atendimento</buttonv></a>
    <a href="index.php"><button class="button1"> Pagina inicial</button></a>

    <p>Exame:<?php echo $nomeex ?> </p>
    <form method="POST">
        <input name='result' type="text" value="<?php echo $result_exame ?>">
        <button  class="button1" type="submit">ok</button>
    </form>
    <p><?php if(isset($sucess)) echo $sucess?></p>
</body>
</html>