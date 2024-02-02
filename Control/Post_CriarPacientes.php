<?php 
// VERICIAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}     

include('../views/conexao.php');
   // VERIFICAÇÃO DA INSERÇÃO DOS CAMPOS POST NO FORM
$alert = "";
if(count($_POST) > 0){
    $email = $_POST['email']; 
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    if(!empty($_POST['sexo'])){
        $sexo = $_POST['sexo'];
    }else{ } 
    
    if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $alert = "CAMPO E-MAIL OBRIGATÓRIO";

    if(empty($_POST['endereco']))
        $alert = "CAMPO ENDEREÇO OBRIGATÓRIO";

    if(empty($_POST['sexo']) )
        $alert = "SELEÇÃO SEXO OBRIGATÓRIA";

    if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $alert = "CAMPO NOME OBRIGATÓRIO";

    if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 )
        $alert = "DATA DE NASCIMENTO DEVE SEGUIR PADRÃO DIA/MÊS/ANO";     

    if(empty($telefone))
        $alert ="CAMPO TELEFONE OBRIGATÓRIO";
        
    if($alert){}
        else{
            $sql_codeverify = "SELECT * FROM pacientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $paciente = $query_c->fetch_assoc();
            $verify = $query_c->num_rows;
                if($verify){
                    $alert = "PACIENTE JÁ CADASTRADO";
                    }
                    else{
                        $sqlinsert = "INSERT INTO pacientes (nome, email, endereco, telefone, nascimento, data, sexo)  
                        values ('$nome', '$email', '$endereco', '$telefone', '$nascimento', NOW(), '$sexo')";
                        $queryinsert = $mysqli->query($sqlinsert);
                            if($queryinsert){
                                $alert = "PACIENTE CADASTRADO COM SUCESSO";
                                header("location: ../views/listagem_pacientes.php");

                            }     
                    }   
                }  
}

?>