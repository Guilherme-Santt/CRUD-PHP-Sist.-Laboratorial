<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../views/conexao.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exames</title>
</head>
<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../estilos/style.css">

<body>
  <!-- HEADER DE INFORMAÇÕES -->
  <header class="header">
    <nav>
      <ul class="list-header">
        <li><a class="btn" href="../Home_Lab/index.php">Home</a></li>
        <!-- PACIENTES -->
        <li><a class="btn" href="../Pacientes_Lab/listagem_pacientes.php">Listagem Pacientes</a></li>
        <li><a class="btn" href="../Pacientes_Lab/Criar_Paciente.php">Cadastrar Pacientes</a></li>

        <!-- USUÁRIOS -->
        <li><a class="btn" href=" ../Usuarios_Lab/listagem_usuarios.php">Configurações de usuários</a></li>

        <!-- EXAMES -->
        <li><a class="btn" href="../Exames_Lab/listagem_exames.php">Cadastro de exames</a></li>
      </ul>
    </nav>
  </header>
  <!-- DIV PARA TABELA COM INFORMAÇÕES DOS EXAMES -->
  <div>
    <div>

      <p>Exames cadastrados em seu sistema</p>
      <table>
        <thead>
          <th>ID exame</th>
          <th>Código exame</th>
          <th>Descrição exame</th>
          <th>Deletar exame</th>
        </thead>
        <tbody>
          <?php 
                // COMANDO SQL PARA CONSULTAR QUANTIDADE DE EXAMES NO SISTEMA
                $sql_exames  = "SELECT * FROM exames";
                $query_exames = $mysqli->query($sql_exames) or die($mysqli->error);
                $num_exames = $query_exames->num_rows;
                    if($num_exames == 0) { 
                    ?>
          <tr>
            <td colspan="3">Nenhum exame foi encontrado!</td>
          </tr>
          <?php }
                        else{ 
                            while($exames = $query_exames->fetch_assoc()){?>
          <tr>
            <td><?php echo $exames['exameid']?> </td>
            <td><?php echo $exames['codigo']?> </td>
            <td><?php echo $exames['descricao']?> </td>
            <td><a href="../Exames_Lab/deletar_exame.php?id=<?php echo $exames['exameid'] ?>">Deletar exame</a></td>
          </tr>
          <?php     }
                        } ?>
        </tbody>
      </table><br>
    </div>
  </div>

  <!-- JANELA MODAL->CADASTRO DE EXAMES NO SISTEMA -->
  <div>
    <div>
      <form action="../Exames_Lab/Post_CriarExames.php" method="POST">
        <p>Cadastrar exame⤵</p>
        <label>Código exame</label><br><br>
        <input type="text" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" name="codigo"><br><br>

        <label>Descrição exame</label></label><br><br>
        <input type="text" value="<?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?>" name="descricao"><br><br>

        <button type="submit" name="cadastrar">Cadastrar exame</button>
      </form>
    </div>
  </div>
</body>

</html>