<?php 
if(!isset($_SESSION)){
  session_start();
  if(!isset($_SESSION['usuario'])){
      header("location: ../Loguin_Lab/index_login.php");
  }    
}
include('../views/conexao.php');
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
    $sexo        = $_POST['sexo'];
    

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
        $sexo        = $_POST['sexo'];
        
        if(empty($nome) || empty($cpf) || empty($rg) || empty($email) || empty($endereco) || empty($cep) || empty($cidade) || empty($nascimento) || empty($telefone) || empty($sexo)){
            die("Todos campos são obrigatórios");
        }else{
            $sql_code = "INSERT INTO pacientes (nome, CPF, RG, email, endereco, CEP, cidade, nascimento, telefone, sexo, data) 
            values ('$nome', '$cpf', '$rg', '$email','$endereco', '$cep', '$cidade', '$nascimento', '$telefone', '$sexo', NOW())";
            $query = $mysqli->query($sql_code);

            if($query){
                header("location: ../Pacientes_Lab/listagem_pacientes.php");
                exit;
            }else {
                die("Erro na inserção de dados");
            }
        }
    };
};
?>