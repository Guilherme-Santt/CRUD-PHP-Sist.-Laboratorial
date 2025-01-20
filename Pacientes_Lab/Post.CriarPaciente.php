<?php 
if(!isset($_SESSION)){
  session_start();
  if(!isset($_SESSION['usuario'])){
      header("location: ../Loguin_Lab/index_login.php");
  }    
}
include('../views/conexao.php');
include('../Control/function.php');

if(count($_POST) > 0){
  $nome        = $_POST['nome'];
  $nome        = verificar_vazio($nome);
  $cpf         = $_POST['CPF'];
  $cpf         = verificar_vazio($cpf);
  $rg          = $_POST['RG'];
  $rg          = verificar_vazio($rg);
  $email       = $_POST['email'];
  $email       = filtro_email($email);
  $endereco    = $_POST['endereco'];
  $endereco    = formatar_data($endereco);
  $cep         = $_POST['CEP'];
  $cep         = verificar_vazio($cep);
  $cidade      = $_POST['cidade'];
  $nascimento  = $_POST['nascimento'];
  $nascimento  = verificar_vazio($nascimento);
  $telefone    = $_POST['telefone'];
  $telefone    = filtro_telefone($telefone);
  $sexo        = $_POST['sexo'];
  
  $sql_code = "INSERT INTO pacientes (nome, CPF, RG, email, endereco, CEP, cidade, nascimento, telefone, sexo) values ('$nome', '$cpf', '$rg', '$email', '$endereco', '$cep', '$cidade', '$nascimento', '$telefone', '$sexo')";
  var_dump($sql_code);
  $query = $mysqli->query($sql_code);
  if($query > 0)
      header("location: ../Pacientes_Lab/listagem_pacientes.php");
};

?>