<?php
include('../conexao.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
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

        if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 ){
            $error = "A data de nascimento deve ser preenchido no padrão dia/mes/ano";
        }
   
        if(empty($telefone)){
            $error ="Campo telefone obrigatório";
            // }else{
            //     $telefone = limpar_texto($telefone);
            //     if(strlen($telefone) != 11){
            //         $error = "O telefone deve ser preenchido no padrão (11) 98888-8888";
            //     }
            }
        
        if($error){
            
        }
        // VERIFICAÇÃO SE O POST EMAIL EXISTE NO BANCO DE DADOS
        else{
            $sql_codeverify = "SELECT * FROM clientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $usuario = $query_c->fetch_assoc();
                if($usuario){
                    $error = "usuário já cadastrado!";
                }
            // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR
                else{
                    $sqlinsert = "INSERT INTO clientes (nome, email, telefone, nascimento, data, senha)  values ('$nome', '$email', '$telefone', '$nascimento', NOW(), '$senha')";
                    $queryinsert = $mysqli->query($sqlinsert);
                        if($queryinsert){
                            header("location: ../views/listagem_usuarios.php");
                            $sucess = "Cadastrado com sucesso";
                            
                        }
                }
        }
    }   
?>
<a href="../listagem_usuarios.php"