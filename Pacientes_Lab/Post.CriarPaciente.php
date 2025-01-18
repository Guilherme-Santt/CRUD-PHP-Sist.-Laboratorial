<?php 
include('../views/conexao.php');

if(count($_POST) > 0){
  $nome        = $_POST['nome'];
  $cpf         = $_POST['CPF'];
  $rg          = $_POST['RG'];
  $email       = $_POST['email'];
  $cep         = $_POST['CEP'];
  $mae         = $_POST['mae'];
  $cidade      = $_POST['cidade'];
  $nascimento  = $_POST['nascimento'];
  $crm         = $_POST['CRM'];
  $convenio    = $_POST['convenio'];
  $diagnostico = $_POST['diagnostico'];
  $observacoes = $_POST['observacoes'];
  $telefone    = $_POST['telefone'];

  if(empty($nome)){
    die(strtoupper("Nome obrigatório."));
  }
};
?>