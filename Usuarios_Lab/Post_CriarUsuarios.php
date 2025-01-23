<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
include('../Control/conexao.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
    $alert = "";
    if(count($_POST) > 0){
        $email      = $_POST['email'];
        $senha      = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $nome       = $_POST['nome'];
        $telefone   = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            die("CAMPO E-MAIL OBRIGATÓRIO");
            exit;
        
        if(empty($_POST['senha']))
            die("CAMPO SENHA OBRIGATÓRIO");

        if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100)
            die("CAMPO NOME OBRIGATÓRIO");
        

        if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 )
            die("NASCIMENTO DEVE SEGUIR DIA/MÊS/ANO");
        
        if(empty($telefone))
        die("TELEFONE OBRIGATÓRIO");
    
        // VERIFICAÇÃO SE O POST EMAIL EXISTE NO BANCO DE DADOS
        }else{
            $sql_codeverify = "SELECT * FROM clientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $usuario = $query_c->fetch_assoc();
                if($usuario){
                    die("USUÁRIO JÁ CADASTRADO");
                }
                 else{ // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR
                    $sqlinsert = "INSERT INTO clientes (nome, email, telefone, nascimento, data, senha)  values ('$nome', '$email', '$telefone', '$nascimento', NOW(), '$senha')";
                    $queryinsert = $mysqli->query($sqlinsert);
                        if($queryinsert){
                            header("location: ../Usuarios_Lab/listagem_usuarios.php");
                        }
                    }
        }
    }
?>
