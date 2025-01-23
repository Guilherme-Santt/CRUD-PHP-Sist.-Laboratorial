<?php
 if(!isset($_SESSION)){
    session_start();
        if(!isset($_SESSION['usuario'])){
          header("location: ../Loguin_Lab/index_login.php");
        }    
      }

      include('../Control/conexao.php');
$id = $_SESSION['usuario'];

// // INFORMAÇÕES DE USUARIOS & QUANTIDADE DE USUARIOS
$sqlcode   = "SELECT * FROM clientes WHERE id = '$id'";
$query     = $mysqli->query($sqlcode);
$usuario   = $query->fetch_assoc();
$cont_user = $query->num_rows;

// // QUANTIDADE E INFORMAÇÕES DE PACIENTES
$sqlcode = "SELECT * FROM pacientes";
$query = $mysqli->query($sqlcode);
$Info_Paciente   = $query->fetch_assoc();
$cont_pacientes = $query->num_rows;

// // QUANTIDADE E INFORMAÇÕES DE EXAMES
$sqlcode = "SELECT * FROM exames";
$query = $mysqli->query($sqlcode);
$cont_exames = $query->num_rows;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tela inicial</title>
</head>
<!-- LINKS CSS -->
<link rel="stylesheet" href="../estilos/style.css">

<body>
  <!-- HEADER DE INFORMAÇÕES -->
  <header class="header">
    <nav>
      <ul class="list-header">
        <li>
          <a class="btn" href="../Home_Lab/index.php">Home</a>
        </li>

        <!-- PACIENTES -->
        <li>
          <a class="btn" href="../Pacientes_Lab/listagem_pacientes.php">Listagem Pacientes</a>
        </li>

        <!-- USUÁRIOS -->
        <li>
          <a class="btn" href=" ../Usuarios_Lab/listagem_usuarios.php">Configurações de usuários</a>
        </li>

        <!-- EXAMES -->
        <li>
          <a class="btn" href="../Exames_Lab/listagem_exames.php">Cadastro de exames</a>
        </li>
        <!-- SAIR -->
        <li>
          <a class="btn" href="../Loguin_Lab/logout.php">Encerrar</a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <h1>
      Instroções de uso de nosso sistema
    </h1>
    <ol>
      <li>
        Em cadastro de exames, vamos conseguir cadastrar os exames para ser inserido nos pacientes. Para criar um exame, basta digitar o código do exame(qnt. máx de 3 dígitos), junto da descrição do exame. NÃO É PERMITIDO EXAMES COM CÓDIGOS IGUAIS.
      </li>
      <li>
        Em listagem de pacientes, nós temos todos pacientes cadastrados em seu sistema. Para cadastrar um paciente novo, deve clicar no botão "cadastrar paciente", ele vai abrir um modal para ser inserido as informações(todas são obrigatórios.)
      </li>
      <ol>
        <li>
          Ainda na listagem de pacientes. Após cadastrar um paciente e ele estiver em visualização, no final da linha, terão as opções editar e remover. Na opção editar, vamos conseguir atualizar as informações do paciente e adicionar os exames.
        </li>
        <li>
        Após entrar em editar, teremos as opções de atualização do paciente e tambem a inserção do exame. Para inserir um exame, é necessário que o exame esteja criado no nosso sistema.
        </li>
      </ol>
      <li>
        Configuração de usuários, é onde nós cadastramos o usuário para conseguir acessar o nosso sistema. Todos campos são obrigatórios. O campo para entrar em nosso sistema é o e-mail, a senha é criptografada. Portanto, cadastre uma senha que se lembre.
      </li>
      <li>
        Sugestões de correção, report ou dicas. Pode me contatar neste endereço de email: guisant@icloud.com
      </li>
    </ol>
  </main>

  <!-- DIVISÃO RODA PÉ DE INFORMAÇÕES -->
  <footer>
    <p>Qnt. usuários cadastrados: <?php echo $cont_user ?></p>
    <p>Qnt. pacientes cadastrados: <?php echo $cont_pacientes ?></p>
    <p>Qnt. exames cadastrados: <?php echo $cont_exames ?></p>
  </footer>
  <script src="..//script.js"> </script>
</body>

</html>