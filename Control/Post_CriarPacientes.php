<?php 
// VERICIAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }  
}      

include('conexao.php');
   // VERIFICAÇÃO DA INSERÇÃO DOS CAMPOS POST NO FORM
$error = "";
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
        $error = "CAMPO E-MAIL OBRIGATÓRIO";

    if(empty($_POST['endereco']))
        $error = "CAMPO ENDEREÇO OBRIGATÓRIO";

    if(empty($_POST['sexo']) )
        $error = "SELEÇÃO SEXO OBRIGATÓRIA";

    if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $error = "CAMPO NOME OBRIGATÓRIO";

    if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 )
        $error = "DATA DE NASCIMENTO DEVE SEGUIR PADRÃO DIA/MÊS/ANO";     

    if(empty($telefone))
        $error ="CAMPO TELEFONE OBRIGATÓRIO";
        
    if($error){}
        else{
            $sql_codeverify = "SELECT * FROM pacientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $paciente = $query_c->fetch_assoc();
            $verify = $query_c->num_rows;
                if($verify){
                    $error = "PACIENTE JÁ CADASTRADO";
                    }
                    else{
                        $sqlinsert = "INSERT INTO pacientes (nome, email, endereco, telefone, nascimento, data, sexo)  
                        values ('$nome', '$email', '$endereco', '$telefone', '$nascimento', NOW(), '$sexo')";
                        $queryinsert = $mysqli->query($sqlinsert);
                            if($queryinsert){
                                $sucess = "PACIENTE CADASTRADO COM SUCESSO";
                            }     
                    }   
                }  
}

?>