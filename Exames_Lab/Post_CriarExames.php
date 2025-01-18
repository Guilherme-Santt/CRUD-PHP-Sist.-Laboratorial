<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
// CÓDIGO PHP
// VERIFICANDO SE O CAMPO DESCRIÇÃO ESTÁ VAZIO
include('../views//conexao.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
if(count($_POST) > 0){
    $codigo    = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    if(empty($_POST['descricao']) || empty($_POST['codigo']) || Strlen($codigo) > 4 ){
        die("EXAME DEVE CONTER 4 DÍGITOS");
    }else{    
        // VERIFICAÇÃO SE O EXAME EXISTE NO BANCO   
        $sql_codeverify = "SELECT * FROM exames WHERE codigo = '$codigo'"; 
        $query_verify = $mysqli->query($sql_codeverify);
        $verify = $query_verify->fetch_assoc();
            if($verify > 0){
                die("EXAME CADASTRADO");
            }else{
                // INSER INTO EXAMES NO BANCO
                $sqlinsert = "INSERT INTO exames (descricao, codigo)  values ('$descricao', '$codigo')";
                $queryinsert = $mysqli->query($sqlinsert) or die();
                    if($queryinsert > 0){
                        // CASO INSERIR O DADO, REDIRECIONAR PARA LISTAGEM DE EXAMES
                        header("location: ../Exames_Lab/listagem_exames.php");
                    }
                }
            }
    };
    
?>