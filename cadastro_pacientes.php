<?php
// SESSÃO 
    include('conexao.php');
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
    function limpar_texto($str){ 
        return preg_replace("/[^0-9]/", "", $str); 
    }
    }

    // VERIFICAÇÃO DA INSERÇÃO DOS CAMPOS POST NO FORM
    $error = "";
    if(count($_POST) > 0){
        $email = $_POST['email'];
        $sexo = $_POST['sexo'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Campo e-mail obrigatório*";
        }
        if(empty($_POST['endereco'])){
            $error = "Campo endereço obrigatório*";
        }
        if(!empty($_POST['sexo']) ){
            if(strlen($sexo) != 3){
                $error = "Escreva campo FEM ou MAS";
            }
        }    
        if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100){
            $error = "Campo nome obrigatório*";
        }
        if(!empty($nascimento)){
            $pedacos = explode('/', $nascimento);
            if(count($pedacos) == 3){
                $nascimento = implode ('-', array_reverse($pedacos)); 
            }
            else{
                $erro = "A data de nascimento deve ser preenchido no padrão dia/mes/ano";
            }
        }    
        if(!empty($telefone)){
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11){
                $erro = "O telefone deve ser preenchido no padrão (11) 98888-8888";
            }
        }
        if($error){

        }else{
            $sql_codeverify = "SELECT * FROM pacientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $paciente = $query_c->fetch_assoc();
            $verify = $query_c->num_rows;
                if($verify){
                    $error = "paciente já cadastrado!";
                }
                else{
                    $sqlinsert = "INSERT INTO pacientes (nome, email, endereco, telefone, nascimento, data, sexo)  
                    values ('$nome', '$email', '$endereco', '$telefone', '$nascimento', NOW(), '$sexo')";
                    $queryinsert = $mysqli->query($sqlinsert);
                        if($queryinsert){
                            $sucess = "Cadastrado com sucesso";
                        }
                }
        }

    }   
    // VISUALIZAÇÃO INFORMAÕES USUARIO CAMPO NO HEADER
    $id = $_SESSION['usuario'];
    $sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
    $query = $mysqli->query($sqlcode);
    $cliente = $query->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</head>
<link rel="stylesheet" href="usuarios.css">
<link rel="stylesheet" href="index.css">
<link rel="stylesheet" href="normalize.css">
<body> 
    <div class="full">
        <a href="index.php">Retornar a pagina inicial</a>
        <a href="pacientes.php">Listagem de pacientes</a>
        <h1>Cadastrar Pacientes</h1>
        <form action="" method="POST">
            <label>Email</label>
            <input class="input_edit" type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>

            <label>Endereço</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>" name="endereco"><br><br>

            <label>Nome</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome"><br><br>

            <label>Nascimento</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano"><br><br>
                
            <label>Telefone:</label>
            <input class="input_edit" value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br><br>
                
            <label>sexo</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['sexo'])) echo $_POST['sexo']; ?>"placeholder="MAS ou FEM" name="sexo"><br><br>

            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>
        <?php 
            if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
            if($error){echo '<p class="error">'. $error . '</p>' ;}   
        ?>
    </div>    
    <script src="index.js"></script>
</body> 
</html>