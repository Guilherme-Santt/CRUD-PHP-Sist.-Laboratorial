<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
$id = $_SESSION['usuario'];
include('../views/conexao.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<link rel="stylesheet" href="../css/index.css">

<body>
  </div>
  <div class="container_body">
    <div class="container_son">
      <form action="../Pacientes_Lab/Post.CriarPaciente.php" method="POST">
        <label>Nome</label>
        <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome">

        <label>CPF</label>
        <input type="text" value="<?php if(isset($_POST['CPF'])) echo $_POST['CPF']; ?>" name="CPF">

        <label>RG</label>
        <input type="text" value="<?php if(isset($_POST['RG'])) echo $_POST['RG']; ?>" name="RG">

        <label>E-mail</label>
        <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>

        <label>Endereço</label>
        <input type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>" name="endereco">

        <label>CEP</label>
        <input type="text" value="<?php if(isset($_POST['CEP'])) echo $_POST['CEP']; ?>" name="CEP">

        <label>Nome da mãe</label>
        <input type="text" value="<?php if(isset($_POST['mae'])) echo $_POST['mae']; ?>" name="mae">

        <label>Cidade</label>
        <input type="text" value="<?php if(isset($_POST['cidade'])) echo $_POST['cidade']; ?>" name="cidade"><br><br>

        <label>Nascimento</label>
        <input type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano">

        <label>CRM</label>
        <input type="text" value="<?php if(isset($_POST['CRM'])) echo $_POST['CRM']; ?>" name="CRM" placeholder="CRM do médico">

        <label>Convênio</label>
        <input type="text" value="<?php if(isset($_POST['convenio'])) echo $_POST['convenio']; ?>" name="convenio">


        <label>Diagnostico</label>
        <input type="text" value="<?php if(isset($_POST['diagnostico'])) echo $_POST['diagnostico']; ?>" name="diagnostico"><br><br>

        <label>Medicamentos</label>
        <input type="text" value="<?php if(isset($_POST['medicamentos'])) echo $_POST['medicamentos']; ?>" name="medicamentos">

        <label>Observações</label>
        <input type="text" value="<?php if(isset($_POST['observacoes'])) echo $_POST['observacoes']; ?>" name="observacoes">

        <label>Telefone:</label>
        <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="11988888888" type="text" name="telefone"><br><br>

        <input type="radio" value="Feminino" name="sexo">Feminino
        <input type="radio" value="Masculino" name="sexo">Masculino<br><br>

        <button type="submit" name="cadastrar">Salvar</button>
      </form>
    </div>
  </div>

</body>

</html>