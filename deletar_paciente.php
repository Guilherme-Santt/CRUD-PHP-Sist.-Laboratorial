<?php
    if(isset($_POST['confirmar'])){ 

        include('conexao.php');
        $id = intval($_GET['id']);
        $sql_code = "DELETE FROM pacientes WHERE id = '$id'";
        $query_code = $mysqli->query($sql_code) or die($mysqli->error);
        
            if($query_code) {?> 
                <h1>Paciente removido com sucesso!</h1>
                <p><a href="pacientes.php">Clique aqui </a>para retornar a listagem de pacientes</p>
                <?php
                die();
            }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente</title>
</head>
<body>
    <form action="" method="POST">
        <h1>Tem certeza que deseja deletar este paciente?</h1>
        <a href="pacientes.php">Não!</a>
        <Button name="confirmar" type="submit">Sim!</Button>
    </form>
</body>
</html>