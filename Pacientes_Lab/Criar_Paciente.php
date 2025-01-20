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
<link rel="stylesheet" href="../Pacientes_Lab/Estilos/style.css">

<body>
  <div class="janela-cadastro">
    <form action="../Pacientes_Lab/Post.CriarPaciente.php" method="POST">
      <ul class="lista-cadastro">
        <h1>Cadastro de pacientes</h1>
        <li>
          <label>Nome.........:</label>
          <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome">
        </li>
        <li>
          <label>CPF............:</label>
          <input type="text" value="<?php if(isset($_POST['CPF'])) echo $_POST['CPF']; ?>" name="CPF">
        </li>
        <li>
          <label>RG.............:</label>
          <input type="text" value="<?php if(isset($_POST['RG'])) echo $_POST['RG']; ?>" name="RG">
        </li>
        <li>
          <label>E-mail........:</label>
          <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email">
        </li>
        <li>
          <label>Endereço....:</label>
          <input type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>" name="endereco">
        </li>
        <li>
          <label>CEP............:</label>
          <input type="text" value="<?php if(isset($_POST['CEP'])) echo $_POST['CEP']; ?>" name="CEP">
        </li>
        <li>
          <label>Cidade........:</label>
          <input type="text" value="<?php if(isset($_POST['cidade'])) echo $_POST['cidade']; ?>" name="cidade">
        </li>
        <li>
          <label>Nascimento:</label>
          <input type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano">
        </li>
        <li>
          <label>Telefone.....:</label>
          <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="11988888888" type="number" name="telefone">
        </li>
        <li class="li-sexo">
          <label>Feminino</label>
          <input type="radio" value="Feminino" name="sexo">
          <label>Masculino</label>
          <input type="radio" value="Masculino" name="sexo">
        </li>
        <li>
          <button type="submit" name="cadastrar">Enviar</button>
        </li>
      </ul>
    </form>
  </div>

</body>

</html>