<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario']));
        header("location: ../views/index_login.php");
}
$id = $_SESSION['usuario'];

include('../views/conexao.php');
if(isset($_POST['authorization'])){
    $arquivo = $_FILES['signature'];
    
    if($arquivo['error'])
        $alert ="FALHA AO ENVIAR ARQUIVO";

    if($arquivo['size'] > 2097152)
        $alert = "ARQUIVO MUITO GRANDE. CAPACIDADE MÁXIMA 2MB";

    $pasta = "assinatura/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION)); 

    if($extensao === 'jpg' || $extensao === 'jpeg' || $extensao === 'png'){
        $assinatura =  $pasta . $novoNomeDoArquivo . "." . $extensao;

    $deu_certo = move_uploaded_file($arquivo['tmp_name'], $assinatura);
    }else{
        $alert = "TIPO DE ARQUIVO NÃO SUPORTADO";
    }

    if($alert){
        die($alert);
    }else{
        $query = $mysqli->query("UPDATE clientes SET assinatura = '$assinatura'"); 
            if($query){
                echo  "<script>alert('ASSINATURA ATUALIZADA');</script>";
                    header("location: ../views/editar_usuario.php?id=$id");
            }

    }
}
?>