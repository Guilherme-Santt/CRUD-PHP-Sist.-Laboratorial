<?php 
// SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="../views/index_login.php">Clique aqui para logar</a>');
    }    
}
include('../Control/function.php');
include('conexao.php');
$id = intval($_GET['id']);

$error = "";
if(count($_POST) > 0){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $unidade = $_POST['unidade'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $error = "Por favor, Prencha o campo nome corretamente. Capacidade mínima 3 dígitos! ";
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $error = "Por favor, Prencha o campo e-mail corretamente.";
    if(empty($nascimento) || strlen($nascimento) != 10){
        $error = "Campo nascimento deve ser preenchido no padrão dia/mês/ano";
    }else{
        $pedacos = explode('/', $nascimento);
        if(count($pedacos) == 3){
            $nascimento = implode ('-', array_reverse($pedacos)); 
        }
    }    
    if(empty($telefone)){
        $error ="Campo telefone obrigatório";
    }else{
        $telefone = limpar_texto($telefone);
        if(strlen($telefone) != 11){
            $error = "O telefone deve ser preenchido no padrão (11) 98888-8888";
        }
    }
    if($error){
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
                $sucess ="Atualizado com sucesso";
                unset($_POST);
            }     
    }         
}
// }
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


<body>
    <form action="" method="POST">
        <p>
            <label>Nome:</label>
            <input value= "<?php echo $cliente['nome']; ?>" type="text" name="nome">
        </p>
        <p>
            <label>E-mail:</label>
            <input value ="<?php echo $cliente['email']; ?>" type="email" name="email">
        </p>
        <label>Unidade:</label>
            <input value ="<?php echo $cliente['unidade']; ?>" type="text" name="unidade">
        </p>
        <p>
            <label>Telefone:</label>
            <input value ="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>" type="text" name="telefone">
        </p>
        <p>
            <label>Data de nascimento:</label>
            <input value ="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>" type="date" name="nascimento">
        </p>
        <?php 
        if(isset($error)){ echo $error;} 
        if(isset($sucess)){ echo $sucess;}
        ?>
        <p>
            <button type="submit">Atualizar</button>
        </p>
    </form>
    <div>
        <a href="listagem_usuarios.php"><button class="button1">Retornar</button></a>
        <a href="index.php"><button class="button1">Pagina inicial</button></a>
    </div>
</body>
</html>

