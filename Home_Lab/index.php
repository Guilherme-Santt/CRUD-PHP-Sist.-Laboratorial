<?php
 if(!isset($_SESSION)){
    session_start();
        if(!isset($_SESSION['usuario'])){
          header("location: ../Loguin_Lab/index_login.php");
        }    
      }

include('../views/conexao.php'); 
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

<link rel="stylesheet" href="../estilos/style.css">

<body>
  <header class="header">
    <nav>
      <ul class="list-header">

        <!-- PACIENTES -->
        <li><a href="../Pacientes_Lab/listagem_pacientes.php">Listagem Pacientes</a></li>
        <li><a href="../Pacientes_Lab/Criar_Paciente.php">Cadastrar Pacientes</a></li>

        <!-- USUÁRIOS -->
        <li><a href=" ../Usuarios_Lab/listagem_usuarios.php">Configurações de usuários</a></li>

        <!-- EXAMES -->
        <li><a href="../Exames_Lab/listagem_exames.php">Cadastro de exames</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <h1>
      Aqui ficará as informações principais
    </h1>
  </main>

  <!-- DIVISÃO RODA PÉ DE INFORMAÇÕES -->
  <footer>
    <p>Qnt. usuários cadastrados: <?php echo $cont_user ?></p>
    <p>Qnt. pacientes cadastrados: <?php echo $cont_pacientes ?></p>
    <p>Qnt. exames cadastrados: <?php echo $cont_exames ?></p>
  </footer>
  <script src="../Home_Lab/script.js"> </script>
</body>

</html>