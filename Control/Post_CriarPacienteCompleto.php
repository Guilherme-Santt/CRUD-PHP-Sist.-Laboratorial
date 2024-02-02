<?php 
// VERICIAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
$id = $_SESSION['id'];
$alert = "";

if(count($_POST) > 0){
    $email = $_POST['email']; 
    $nome = $_POST['nome'];
    $RG = $_POST['RG'];
    $CPF = $_POST['CPF'];
    $endereco = $_POST['endereco'];
    $CEP = $_POST['CEP'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $CRM = $_POST['CRM'];
    $convenio = $_POST['convenio'];
    $diagnostico = $_POST['diagnostico'];
    $medicamentos = $_POST['medicamentos'];
    $observacoes = $_POST['observacoes'];
    $mae = $_POST['mae'];

    if(!empty($_POST['sexo'])){
        $sexo = $_POST['sexo'];
    }else{ } 
    
    if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $alert ="CAMPO E-MAIL OBRIGATÓRIO";
    }
    if(empty($_POST['endereco']))
        $alert ="CAMPO ENDEREÇO OBRIGATÓRIO";

    if(empty($_POST['CEP']))
        $alert ="CAMPO CEP OBRIGATÓRIO";

    if(empty($_POST['cidade']))
        $alert ="CAMPO CIDADE OBRIGATÓRIO";

    if(empty($_POST['convenio']))
        $alert = "CONVÊNIO OBRIGATÓRIO";

    $verify_convenio = $mysqli->query("SELECT * FROM convenio WHERE nome = '$convenio'");
    $verifyc = $verify_convenio->fetch_assoc();
    if($verifyc){
        $convenio;
    }else{
        $alert = "CONVÊNIO NÃO CADASTRADO";
    }

    if(empty($_POST['sexo']) )
        $alert ="SELEÇÃO SEXO OBRIGATÓRIA";

    if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $alert ="CAMPO NOME OBRIGATÓRIO";

    if(empty($_POST['RG']))
        $alert ="CAMPO RG OBRIGATÓRIO";

    if(empty($_POST['CPF']))
        $alert ="CAMPO CPF OBRIGATÓRIO";

    if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 )
        $alert ="DATA DE NASCIMENTO DEVE SEGUIR PADRÃO DIA/MÊS/ANO";     

    if(empty($telefone))
        $alert ="CAMPO TELEFONE OBRIGATÓRIO";

    if($alert){
        die("$alert");
    }else{
        include('../views/conexao.php');
        $sqlinsert = "INSERT INTO pacientes (nome, RG, CPF, email, endereco, CEP, cidade, telefone, nascimento, CRM, convenio, diagnostico, medicamentos, observacoes, mae, data, sexo, id_user)  
        values  ('$nome', '$RG', '$CPF', '$email', '$endereco', '$CEP', '$cidade', '$telefone', '$nascimento', '$CRM', '$convenio', '$diagnostico','$medicamentos', '$observacoes', '$mae', NOW(), '$sexo', '$id')";
        $queryinsert = $mysqli->query($sqlinsert) or die($mysqli->error);
        if($queryinsert)
            header("location: ../views/Criar_Paciente.php");
    }  
       
}
        

?>