<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
$id = $_SESSION['usuario'];
include('../views/conexao.php');

// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
if(count($_POST) > 0){
    $codigo    = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    
    // VERIFICANDO SE O CAMPO DESCRIÇÃO ESTÁ VAZIO
    if(empty($_POST['descricao']))
        die("DESCRIÇÃO OBRIGATÓRIA");
    
    // VERIFICANDO SE O CAMPO CÓDIGO ESTÁ VAZIO OU MAIOR QUE 4 DÍGITOS
    if(empty($_POST['codigo']) || Strlen($codigo) > 4)
        die("QT DO EXAME DEVE CONTER NO MÍNIMO 4 DÍGITOS");
    
    // VERIFICANDO SE CONTÉM ALGUM ERRO-.> CASO TIVER TERÁ UM IF ISSET ERRO A BAIXO DO FORM
    if(die){
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
                        header("location: ../Exames_Lab/listagem_exames.php");
                    }
            }
    }
}   
?>