<?php 
if(!isset($_SESSION)){
  session_start();
  if(!isset($_SESSION['usuario'])){
  }    
}
include('../Control/conexao.php');
include('../Control/function.php');
$error = "";
$sucess = "";

if(count($_POST)){
    $nome        = $_POST['nome'];
    $cpf         = $_POST['CPF'];
    $rg          = $_POST['RG'];
    $email       = $_POST['email'];
    $endereco    = $_POST['endereco'];
    $cep         = $_POST['CEP'];
    $cidade      = $_POST['cidade'];
    $nascimento  = $_POST['nascimento'];
    $telefone    = $_POST['telefone'];
    $sexo        = isset($_POST['sexo']) ? $_POST['sexo'] : null;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "E-mail inválido!";
        header("location: ../public/listagem_pacientes.php");
        exit;
    }
    
    // VERIFICAÇÃO SE ALGUM DOS CAMPOS ESTÁ VAZIO
    if(empty($nome) || empty($cpf) || empty($rg) || empty($email) || empty($endereco) || empty($cep) || empty($cidade) || empty($nascimento) || empty($telefone) || empty($sexo)){
        $error = "Todos campos são obrigatórios";
        $_SESSION['error'] = $error;
        header("location: ../public/listagem_pacientes.php");
        exit;
    }
    else{
        // INSERÇÃO DAS INFORMAÇÕES NO BANCO DE DADOS
        $sql_code = "INSERT INTO pacientes 
        (nome, CPF, RG, email, endereco, CEP, cidade, nascimento, telefone, sexo, data) 
        values ('$nome', '$cpf', '$rg', '$email','$endereco', '$cep', '$cidade', '$nascimento', '$telefone', '$sexo', NOW())";
        $query = $mysqli->query($sql_code);

        if($query){
            // SE INSERIR OS DADOS, VAI DIRECIONAR A PÁGINA PARA A LISTAGEM DE PACIENTES
            $sucess = "Cadastrado com sucesso";
            $_SESSION['sucess'] = $sucess;
            header("location: ../public/listagem_pacientes.php");
            exit;   
        }else {
            // CASO DER ERRO NA INSERÇÃO AO BANCO, VAI RETORNAR ERRO
            $error = "Erro na inserção de dados";
            $_SESSION['error'] = $error;
            header("location: ../public/listagem_pacientes.php");
            exit;
        }
    }
};
?>