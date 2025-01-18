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
<link rel="stylesheet" href="../css/button.css">

<body>
  <!-- DIVISÃO GERAL DAS INFORMAÇÕES NO CONTAINER -->
  <div class="container_body">
    <!-- TABELA DE USUARIOS CADASTRADOS LABORATÓRIO -->
    <div class="container_son">
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

  <!-- CASTRO DE PACIENTES -->
  <div>
    <div">
      <form action="../Usuarios_Lab/Post_CriarUsuarios.php" method="POST">
        <p>Cadastrar usuário⤵</p>
        <label>Email</label><br>
        <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>

        <label>Nome</label><br>
        <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome"><br><br>

        <label>Nascimento</label><br>
        <input type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento"><br><br>

        <label>Telefone:</label><br>
        <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="11988888888" type="text" name="telefone"><br><br>

        <label>Senha</label><br>
        <input type="password" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" name="senha"><br><br>
        <button type="submit" name="cadastrar">Enviar </button>
      </form>
      </dv>
  </div>
</body>

</html>