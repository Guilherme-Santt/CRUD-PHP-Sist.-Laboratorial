<?php

    include('conexao.php');

    $id = intval($_GET['id']);
    $from_id = "SELECT * FROM exames WHERE exameid = '$id'";
    $query_from = $mysqli->query($from_id);
    $exame = $query_from->fetch_assoc();


    if(isset($_POST['confirmar'])){
        $id = intval($_GET['id']);

        $sql_code = "DELETE FROM exames WHERE exameid = '$id'";
        $query_code = $mysqli->query($sql_code);
        var_dump($sql_code);
            if($query_code) {?> 
                <h1>Paciente removido com sucesso!</h1>
                <p><a href="exames.php">Clique aqui </a>para retornar a listagem de pacientes</p>
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
        <h1>Tem certeza que deseja deletar este exame:   <?php echo $exame['nome']?>?</h1>
        <a href="exames.php">Não!</a>
        <Button name="confirmar" type="submit">Sim!</Button>
    </form>
</body>
</html>