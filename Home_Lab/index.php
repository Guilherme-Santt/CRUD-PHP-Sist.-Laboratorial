<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}

include('../views/conexao.php');
$id = $_SESSION['usuario'];

// INFORMAÇÕES DE USUARIOS & QUANTIDADE DE USUARIOS
$sqlcode   = "SELECT * FROM clientes WHERE id = '$id'";
$query     = $mysqli->query($sqlcode);
$usuario   = $query->fetch_assoc();
$cont_user = $query->num_rows; 

// QUANTIDADE E INFORMAÇÕES DE PACIENTES
$sqlcode = "SELECT * FROM pacientes";
$query = $mysqli->query($sqlcode);
$Info_Paciente   = $query->fetch_assoc();
$cont_pacientes = $query->num_rows;

// QUANTIDADE E INFORMAÇÕES DE EXAMES
$sqlcode = "SELECT * FROM exames";
$query = $mysqli->query($sqlcode);
$cont_exames = $query->num_rows;

// POST PARA ENVIO DE SUGESTÕES
if(isset($_POST['sugestao'])){
    $error = "";
    $sugestao = $_POST['sugestao'];
    if(empty($_POST['sugestao'])){
        $error = "Campo obrigatório*";
    }
    if($error){

    }else{
    $enviado = "";
    $sql_code = "SELECT * FROM sugestoes WHERE sugestao = '$sugestao'";
    $query = $query_sug = $mysqli->query($sql_code);
    $consulta_sugestao = $query->fetch_assoc();
    
        if($consulta_sugestao){
            echo "<script>alert('Sugestão já enviada. Caso tiver outra sugestão, será um prazer avaliar!');</script>";
        }
        else{
            $sql_code = "INSERT INTO sugestoes (id_user, sugestao) VALUES ('$id', '$sugestao')";
            $query_sug = $mysqli->query($sql_code);
            if($query_sug){
                echo "<script>alert('Sugestão enviada com sucesso! Iremos avaliar a possibilidade e dare mos retorno no email cadastrado. Obrigado.');</script>";
            }
        }    
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela inicial</title>
</head>

<link rel="stylesheet" href="../css/modal.css">
<link rel="stylesheet" href="../css/button.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/index.css">

<body>
  <a href="../Pacientes_Lab/Criar_Paciente.php">Cadastrar Pacientes</a>
  <a href="../Pacientes_Lab/listagem_pacientes.php">Listagem Pacientes</a>
  <a href="../Usuarios_Lab/listagem_usuarios.php">Configuração de usuários</a>
  <a href="../Exames_Lab/listagem_exames.php">Cadastro de exames</a>
  <a href=""></a>
  <!-- DIVISÃO RODA PÉ DE INFORMAÇÕES -->
  <div class=" rodape">
    <p>Qnt. usuários cadastrados: <?php echo $cont_user ?></p>
    <p>Qnt. pacientes cadastrados: <?php echo $cont_pacientes ?></p>
    <p>Qnt. exames cadastrados: <?php echo $cont_exames ?></p>
  </div>
</body>

</html>