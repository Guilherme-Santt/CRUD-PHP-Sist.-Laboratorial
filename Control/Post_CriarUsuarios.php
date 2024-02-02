<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../views/conexao.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
    $alert = "";
    if(count($_POST) > 0){
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $alert = "CAMPO E-MAIL OBRIGATÓRIO";
        
        if(empty($_POST['senha']))
            $alert = "CAMPO SENHA OBRIGATÓRIO";
         
        if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100)
            $alert = "CAMPO NOME OBRIGATÓRIO";
        

        if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 )
            $alert = "NASCIMENTO DEVE SEGUIR DIA/MÊS/ANO";
        
        if(empty($telefone))
            $alert ="TELEFONE OBRIGATÓRIO";
            
        if($alert){
            
        }
        // VERIFICAÇÃO SE O POST EMAIL EXISTE NO BANCO DE DADOS
        else{
            $sql_codeverify = "SELECT * FROM clientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $usuario = $query_c->fetch_assoc();
                if($usuario){
                    $alert = "USUÁRIO JÁ CADASTRADO";
                }
            // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR
                else{
                    $sqlinsert = "INSERT INTO clientes (nome, email, telefone, nascimento, data, senha)  values ('$nome', '$email', '$telefone', '$nascimento', NOW(), '$senha')";
                    $queryinsert = $mysqli->query($sqlinsert);
                        if($queryinsert){
                            header("location: ../views/listagem_usuarios.php");
                            $sucess = "CADASTRADO COM SUCESSO";

                        }
                }
        }
    }   
?>
<a href="../listagem_usuarios.php"