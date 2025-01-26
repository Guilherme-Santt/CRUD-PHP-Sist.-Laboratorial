    <?php
    $sucess = "";
    include('../Control/conexao.php');
    $id = intval($_GET['id']);
    $sql_code   = "DELETE FROM pacientes WHERE id = '$id'";
    $query_code = $mysqli->query($sql_code) or die($mysqli->error);
        if($query_code){
            $sucess = "Deletado com sucesso";
            $_SESSION['sucess'] = $sucess;
            header("location: ../listagem_pacientes.php");  
        }
          ?>