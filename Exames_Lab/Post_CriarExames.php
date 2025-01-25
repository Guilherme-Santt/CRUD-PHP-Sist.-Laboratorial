<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
// CÓDIGO PHP
// VERIFICANDO SE O CAMPO DESCRIÇÃO ESTÁ VAZIO
include('../Control/conexao.php');
include('../Control/function.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
if(count($_POST) > 0){
    $codigo    = strtoupper($_POST['codigo']);
    $descricao = $_POST['descricao'];
    $valor     = formatar($_POST['valor']);
    if(empty($descricao) || empty($codigo) || empty($valor) || Strlen($codigo) > 4 ){
        die("CADASTRO INVÁLIDO");
    }else{    
        // VERIFICAÇÃO SE O EXAME EXISTE NO BANCO   
        $sql_codeverify = "SELECT * FROM exames WHERE codigo = '$codigo'"; 
        $query_verify = $mysqli->query($sql_codeverify);
        $verify = $query_verify->fetch_assoc();
            if($verify > 0){
                die("EXAME CADASTRADO");
            }else{
                // INSER INTO EXAMES NO BANCO
                $sqlinsert = "INSERT INTO exames (descricao, codigo, valor)  values ('$descricao', '$codigo', '$valor')";
                $queryinsert = $mysqli->query($sqlinsert) or die();
                    if($queryinsert > 0){
                        // CASO INSERIR O DADO, REDIRECIONAR PARA LISTAGEM DE EXAMES
                        header("location: ../listagem_exames.php");
                    }
                }
            }
    };
    
?>