<?php   
    include('conexao.php');

    function limpar_texto($str){ 
        return preg_replace("/[^0-9]/", "", $str); 
      }
  
    $error = "";
    if(count($_POST) > 0){
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "preencha o campo email!";
        }
        if(empty($_POST['senha'])){
            $error = "preencha o campo senha!";
        }  
        if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100){
            $error = "preencha o campo nome!";
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
            $sql_codeverify = "SELECT * FROM clientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $usuario = $query_c->fetch_assoc();
            $verify = $query_c->num_rows;
                if($verify){
                    $error = "usuário já cadastrado!";
                }
                else{
                    $sqlinsert = "INSERT INTO clientes (nome, email, telefone, nascimento, data, senha)  values ('$nome', '$email', '$telefone', '$nascimento', NOW(), '$senha')";
                    $queryinsert = $mysqli->query($sqlinsert);
                        if($queryinsert){
                            $sucess = "Cadastrado com sucesso";
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
    <title>Document</title>
</head>
        <style>
            .error{
                color:red;
            }
            .sucess{
                color:green;
            }
            h1{
                font-size: 20px;
            }
        </style>
<body>
    <h1>Cadastrar um novo usuário</h1>
    <form action="" method="POST">
        <label>Email</label>
        <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>

        <label>Nome</label>
        <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome"><br><br>

        <label>Nascimento</label>
        <input type="text" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano"><br><br>
        
        <label>Telefone:</label>
        <input value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br><br>
        
        <label>Senha</label>
        <input type="password" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" name="senha"><br><br>

        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
    <a href="logout.php">Encerrar sessão</a>
    <?php 
        if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
        if($error){echo '<p class="error">'. $error . '</p>' ;}   
    ?>
</body>
</html>