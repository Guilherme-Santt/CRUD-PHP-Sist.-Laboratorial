<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
$id = $_SESSION['usuario'];
include('../views/conexao.php');
include('../Control/SelectFrom.php');

$error = "";
$sucess = "";
// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
if(count($_POST) > 0){
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    // VERIFICANDO SE O CAMPO DESCRIÇÃO ESTÁ VAZIO
    if(empty($_POST['descricao']))
        die("DESCRIÇÃO OBRIGATÓRIA");
    
    // VERIFICANDO SE O CAMPO CÓDIGO ESTÁ VAZIO OU MAIOR QUE 3 DÍGITOS
    if(empty($_POST['codigo']) || Strlen($codigo) > 3)
        die("CAMPO CÓDIGO DEVE CONTER 3 DÍGITOS");
    
    // VERIFICANDO SE CONTÉM ALGUM ERRO-.> CASO TIVER TERÁ UM IF ISSET ERRO A BAIXO DO FORM
    if($error){

    }
    // VERIFICAÇÃO SE O POST CÓDIGO EXISTE NO BANCO DE DADOS, PARA NÃO DUPLICAR EXAME AO CRIAR
    else{
        $sql_codeverify = "SELECT * FROM exames WHERE codigo = '$codigo'";
        $query_c = $mysqli->query($sql_codeverify);
        $verify = $query_c->fetch_assoc();
            if($verify)
                die("EXAME JÁ CADASTRADO");
            
        // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR O CÓDIGO 
            else{
                $sqlinsert = "INSERT INTO exames (descricao, codigo)  values ('$descricao', '$codigo')";
                $queryinsert = $mysqli->query($sqlinsert);
                    if($queryinsert){
                        header("location: ../views/listagem_exames.php");
                    }
            }
    }
}   
?>