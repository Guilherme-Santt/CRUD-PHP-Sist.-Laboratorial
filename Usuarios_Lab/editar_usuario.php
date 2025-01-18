<?php 
// SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
include('../Control/function.php');
include('../views/conexao.php');
    $id = intval($_GET['id']);

$alert = "";
if(count($_POST) > 0){
    $authorization = $_POST['authorization'];
        if(!isset($authorization))
            $alert ="ERROR";

    $nome = $_POST['nome'];
        if(empty($nome))
            $alert = "CAMPO VÁZIO";
    $email = $_POST['email'];
        if(empty($email))    
            $alert = "CAMPO VÁZIO";
    $unidade = $_POST['unidade'];
        if(empty($unidade))
            $alert = "CAMPO VÁZIO";
    $telefone = $_POST['telefone'];
        if(empty($telefone))
            $alert = "CAMPO VÁZIO";
    $nascimento = $_POST['nascimento'];
        if(empty($nascimento))
            $alert = "CAMPO VÁZIO";

    if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $alert = "CAMPO NOME INVÁLIDO OU INCORRETO ";
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $alert = "CAMPO E-MAIL INVÁLIDO OU INCORRETO.";
    if(empty($nascimento) || strlen($nascimento) != 10)
        $alert = "CAMPO NASCIMENTO INCORRÉTO";
        
    if(empty($telefone) || strlen($telefone) != 11)
        $alert ="CAMPO TELEFONE INVÁLIDO OU INCORRÉTO";

    if($alert){
        die($alert);
    }
     else{
        $sql_code = "UPDATE clientes
        SET nome   = '$nome', 
        email      = '$email',
        unidade    = '$unidade',
        telefone   = '$telefone',
        nascimento = '$nascimento' WHERE id   = '$id'";
        $deu_certo = $mysqli->query($sql_code);
            if($deu_certo){
                echo  "<script>alert('ATUALIZADO COM SUCESSO');</script>";
            }     
    }         

}
// SELECT FROM NA TABELA CLIENTES, PARA PUXAR INFORMAÇÕES DOS PACIENTES PARA OS CAMPOS INPUT
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente = $query_cliente->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listagem de usuários</title>
</head>

<link rel="stylesheet" href="../css/button.css">

<body>
  <div class="container_body">
    <div class="container_son">
      <form action="" method="POST">
        <label>Nome:</label>
        <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome">

        <label>E-mail:</label>
        <input value="<?php echo $cliente['email']; ?>" type="email" name="email">

        <label>Unidade:</label>
        <input value="<?php echo $cliente['unidade']; ?>" type="text" name="unidade">

        <label>Telefone:</label>
        <input value="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>" type="text" name="telefone">

        <label>Data de nascimento:</label>
        <input value="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>" type="date" name="nascimento">
        <?php 
                if(isset($error)){ echo $error;} 
                if(isset($sucess)){ echo $sucess;}
                ?>
        <button class="btn_style" name="authorization" type="submit">Atualizar</button>
      </form>
      <script src="../src/modal.js"></script>
</body>

</html>