<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}

// SELECT FROM NA COLUNA EXAMES PARA PUXAR NOME DO EXAME
include('../conexao/conexao.php');
$id = intval($_GET['id']);
$from_id = "SELECT * FROM exames WHERE exameid = '$id'";
$query_from = $mysqli->query($from_id);
$exame = $query_from->fetch_assoc();
$exame_nome = $exame['descricao'];

// VERIFICAÇÃO DO SUBMITE CONFIRMAR,FAZENDO O DELETE DO ID EXAME VINDO DO GET
if(isset($_POST['confirmar'])){
    $id = intval($_GET['id']);
    $sql_code = "DELETE FROM exames WHERE exameid = '$id'";
    $query_code = $mysqli->query($sql_code);
        if($query_code) {?> 
            <h1>Exame removido com sucesso!</h1>
            <p><a href="../index_exames/exames.php">Clique aqui </a>para retornar ao cadastro de exames</p>
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
    <title>Deletar exame</title>
</head>

<body>
    <form action="" method="POST">
        <h1>Remover exame: <?php echo $exame_nome?>?</h1>
        <a href="../index_exames/exames.php">Não!</a>
        <Button  name="confirmar" type="submit">Sim!</Button>
    </form>
</body>
</html>