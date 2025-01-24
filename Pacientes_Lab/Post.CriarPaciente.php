<?php 
if(!isset($_SESSION)){
  session_start();
  if(!isset($_SESSION['usuario'])){
include('../Control/conexao.php');
  }    
}
include('../Control/conexao.php');
include('../Control/function.php');
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

    // VERIFICAÇÃO SE ALGUM DOS CAMPOS ESTÁ VAZIO
    if(empty($nome) || empty($cpf) || empty($rg) || empty($email) || empty($endereco) || empty($cep) || empty($cidade) || empty($nascimento) || empty($telefone) || empty($sexo)){
        die("Todos campos são obrigatórios");
        var_dump($sexo);
        exit;
    }else{
        // INSERÇÃO DAS INFORMAÇÕES NO BANCO DE DADOS
        $sql_code = "INSERT INTO pacientes (nome, CPF, RG, email, endereco, CEP, cidade, nascimento, telefone, sexo, data) 
        values ('$nome', '$cpf', '$rg', '$email','$endereco', '$cep', '$cidade', '$nascimento', '$telefone', '$sexo', NOW())";
        $query = $mysqli->query($sql_code);

        if($query){
            // SE INSERIR OS DADOS, VAI DIRECIONAR A PÁGINA PARA A LISTAGEM DE PACIENTES
            header("location: ../Pacientes_Lab/listagem_pacientes.php");
            exit;
        }else {
            // CASO DER ERRO NA INSERÇÃO AO BANCO, VAI RETORNAR ERRO
            die("Erro na inserção de dados");
            exit;
        }
    }
};
?>