<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
include('../Control/conexao.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
$error = "";
$sucess = "";
if(count($_POST) > 0){
    $email      = $_POST['email'];
    $senha      = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $nome       = $_POST['nome'];
    $telefone   = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "E-mail inválido";
        $_SESSION['error'] = $error;
        header("location: ../listagem_usuarios.php");
        exit;
    }
    
    if(empty($_POST['senha'])){
        $_SESSION['error'] = $error;
        $error = "Senha inválida";
        header("location: ../listagem_usuarios.php");
        exit;
    }

    if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100){
        $error = "Nome inválido";

    }
    if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 ){
        $error = "Data de nascimento inválido";
    }
    
    if(empty($telefone)){
        $error = "Telefone inválido";
    }

    // VERIFICAÇÃO SE O POST EMAIL EXISTE NO BANCO DE DADOS
    if($error){
        $_SESSION['error'] = $error;
        header("location: ../public/listagem_usuarios.php");
        exit;
    }else{
        $sql_codeverify = "SELECT * FROM clientes WHERE email = '$email'";
        $query_c = $mysqli->query($sql_codeverify);
        $usuario = $query_c->fetch_assoc();
            if($usuario){
                $error = "E-mail duplicado";
                $_SESSION['error'] = $error;
                header("location: ../public/listagem_usuarios.php");
            }
                else{ // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR
                $sqlinsert = "INSERT INTO clientes (nome, email, telefone, nascimento, data, senha)  values ('$nome', '$email', '$telefone', '$nascimento', NOW(), '$senha')";
                $queryinsert = $mysqli->query($sqlinsert);
                    if($queryinsert){
                        $sucess = "Cadastrado com sucesso";
                        $_SESSION['sucess'] = $sucess;
                        header("location: ../public/listagem_usuarios.php");
                    }
                }
    }
}
?>