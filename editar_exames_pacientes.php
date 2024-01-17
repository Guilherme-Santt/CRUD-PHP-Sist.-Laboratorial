<?php 
// SESSÃO
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
}
    $id = intval($_GET['id']);
    include('conexao.php');

?>

<?php

    $sql_code = "SELECT pacientes.id as id_paciente, exames.nome as nome_exame, exames.codigo as codigo_exame, pacientes.nome as nome_paciente, exames.descricao as descricao_exame FROM pacientes_exames, pacientes, exames WHERE pacientes_exames.exame_id = exames.exameid AND pacientes_exames.paciente_id = pacientes.id";
    $query_code = $mysqli->query($sql_code);
    $num_clientes = $query_code->num_rows;
    $pacientes = $query_code->fetch_assoc();
    $error = "";


    if(count($_POST) > 0){
        $id_paciente =  $_POST['paciente'];
        $id_exame =     $_POST['exame'];
   
    
        if(empty($id_exame)){
            $error = "CAMPO ID EXAME OBRIGATÓRIO* ";
        }
        if(empty($id_paciente)){
            $error = "CAMPO ID PACIENTE OBRIGATÓRIO* ";
        }

        if($error){
            // echo "<p><b>$erro</b></p>";
        }
        $sql_code = "SELECT exames.exameid as id_exame, pacientes.id as id_paciente, exames.nome as nome_exame, exames.codigo as codigo_exame, pacientes.nome as nome_paciente, exames.descricao as descricao_exame FROM pacientes_exames, pacientes, exames WHERE pacientes_exames.exame_id = exames.exameid AND pacientes_exames.paciente_id = pacientes.id";
        $query_code = $mysqli->query($sql_code);
        $num_clientes = $query_code->num_rows;
        $exame = $query_code->fetch_assoc();
        $error = "";
            if($exame){
                $error = "Exame já adicionado ao paciente!";
            }else{
    
                $sql_code = "INSERT INTO pacientes_exames (paciente_id, exame_id) VALUES ('$id_paciente', '$id_exame')";
                $query = $mysqli->query($sql_code);
                $deu_certo = $mysqli->query($sql_code);

                    if($deu_certo){
                        $sucess ="Exame adicionado";
                        unset($_POST);
                    }             
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
    <a href="exames_paciente.php">Retornar aos exames dos pacientes</a>
    <form action="" method="POST">

        <p>
            <label>ID exame</label>
            <input value= "<?php if(isset($_POST['exame'])) echo $_POST['exame']; ?>" type="text" name="exame">
        </p>
        <p>
            <label>ID Paciente</label>
            <input value= "<?php if(isset($_POST['paciente'])) echo $_POST['paciente']; ?>" type="text" name="paciente">
        </p>
        <p>
            <button type="submit">Enviar</button>
        </p>
        <?php 
            if(isset($error)){ echo $error;} 
            if(isset($sucess)){ echo $sucess;}
        ?>
    </form>
</body>
</html>

