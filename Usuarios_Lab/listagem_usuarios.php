<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../Loguin_Lab/index_login.php");
    }    
}
include('../views/conexao.php');
include('../Control/function.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuários</title>
</head>
<!-- ARQUIVOS CSS SITE -->
<link rel="stylesheet" href="../estilos/style.css">

<body>
  <!-- HEADER DE INFORMAÇÕES -->
  <header class="header">
    <nav>
      <ul class="list-header">
        <li><a class="btn" href="../Home_Lab/index.php">Home</a></li>
        <!-- PACIENTES -->
        <li><a class="btn" href="../Pacientes_Lab/listagem_pacientes.php">Listagem Pacientes</a></li>
        <!-- USUÁRIOS -->
        <li><a class="btn" href=" ../Usuarios_Lab/listagem_usuarios.php">Configurações de usuários</a></li>
        <!-- EXAMES -->
        <li><a class="btn" href="../Exames_Lab/listagem_exames.php">Cadastro de exames</a></li>
      </ul>
    </nav>
  </header>
  <!-- END HEADER -->
  <!-- DIVISÃO GERAL DAS INFORMAÇÕES NO CONTAINER -->
  <div class="container_body">
    <!-- TABELA DE USUARIOS CADASTRADOS LABORATÓRIO -->
    <div class="container_son">
      <button id="AbrirModal">Cadastrar Paciente</button>
      <p>Usuários cadastrados no seu sistema</p>
      <table ID="alter" cellpadding="10">
        <thead>
          <th>ID</th>
          <th>Nome</th>
          <th>Unidade</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Data de nascimento</th>
          <th>Data de cadastro</th>
          <th>Ações</th>
        </thead>
        <tbody>
          <?php 
                    // COMANDO SQL PARA CONSULTAR QUANTIDADE DE USUÁRIOS NO SISTEMA
                    $sql_clientes   = "SELECT * FROM clientes";
                    $query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
                    $num_clientes = $query_clientes->num_rows;
                    if($num_clientes == 0) { 
                        ?>
          <tr>
            <td colspan="7">Nenhum usuário foi encontrado!</td>
          </tr>
          <?php }
                    else{ 
                        while($cliente = $query_clientes->fetch_assoc()){
                            $telefone ="Não informado!";
                            if(!empty($cliente['telefone'])){
                                $telefone = formatar_telefone($cliente['telefone']);   
                            }
                                $nascimento = "Nascimento não informada!";
                            if(!empty($cliente['nascimento'])){
                                $nascimento = formatar_data($cliente['nascimento']);
                            }
                            $data_cadastro = date("d/m/y H:i:s", strtotime($cliente['data']));
                    ?>
          <tr>
            <td><?php echo $cliente['id']?> </td>
            <td><?php echo $cliente['nome']?> </td>
            <td><?php echo $cliente['unidade']?> </td>
            <td><?php echo $cliente['email']?> </td>
            <td><?php echo $telefone; ?> </td>
            <td><?php echo $nascimento ?> </td>
            <td><?php echo $data_cadastro;?> </td>
            <td>
              <a class="edit" href="editar_usuario.php?id=<?php echo $cliente['id']?>">Editar</a>
              <a class="error" href="../Usuarios_Lab/deletar_usuario.php?id=<?php echo $cliente['id']?>">Deletar</a>
            </td>
          </tr>
          <?php
                    }
                }
                ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- END VISUALIZAÇÃO DE USUARIOS -->
  <!-- MODAL CADASTRO DE USUARIOS -->
  <div class="container-modal" id="container-modal">
    <div class="janela-cadastro">
      <form action="../Usuarios_Lab/Post_CriarUsuarios.php" method="POST">
        <ul class="lista-cadastro">
          <button class="close">x</button>
          <li>
            <label>Email.........:</label>
            <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email">
          </li>

          <li>
            <label>Nome.........:</label>
            <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome">
          </li>

          <li>
            <Label> Nascimento.:</Label>
            <input type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento">
          </li>
          <li>
            <label>Telefone.....:</label>
            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="11988888888" type="text" name="telefone">
          </li>
          <li>
            <label>Senha........:</label>
            <input type="password" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" name="senha">
          </li>
          <li>
            <button type="submit" name="cadastrar">Enviar </button>
          </li>
        </ul>
      </form>
      </dv>
    </div>
    <!-- END MODAL -->
    <script src="../src/script.js"></script>
</body>

</html>