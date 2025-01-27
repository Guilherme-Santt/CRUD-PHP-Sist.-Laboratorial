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
$error  = "";
$sucess = "";
// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
if(count($_POST) > 0){
    $codigo    = strtoupper($_POST['codigo']);
    $descricao = $_POST['descricao'];
    $valor     = $_POST['valor'];
    $valor     = formatar($valor);
    
    if(empty($descricao) || empty($codigo) || empty($valor) || Strlen($codigo) > 4 ){
        $error = "Todos campos são obrigatórios";
    }
  
    // VERIFICAÇÃO SE O EXAME EXISTE NO BANCO   
    $sql_codeverify = "SELECT codigo FROM exames WHERE codigo = '$codigo'"; 
    $query_verify = $mysqli->query($sql_codeverify);
    $verify = $query_verify->fetch_assoc();
    if($verify){
        $error = "Exame duplicado";
        $_SESSION['error'] = $error;
        header("location: ../public/listagem_exames.php");
        exit;
    }
    
    if($error){
        $_SESSION['error'] = $error;
        header("location: ../public/listagem_exames.php");
        exit;
    }else{
        // INSER INTO EXAMES NO BANCO
        $sqlinsert = "INSERT INTO exames (descricao, codigo, valor)  values ('$descricao', '$codigo', '$valor')";
        $queryinsert = $mysqli->query($sqlinsert) or die();
            if($queryinsert > 0){
                // CASO INSERIR O DADO, REDIRECIONAR PARA LISTAGEM DE EXAMES
                $sucess = "Cadastro com sucesso";
                $_SESSION['sucess'] = $sucess;
                header("location: ../public/listagem_exames.php");
            }
        }
};
    
?>