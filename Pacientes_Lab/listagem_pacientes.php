<?php 
include('../Control/conexao.php');
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../Control/function.php');

$sql_pacientes   = "SELECT * FROM pacientes";
$query_pacientes = $mysqli->query($sql_pacientes) or die($mysqli->error);
$num_pacientes = $query_pacientes->num_rows; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pacientes</title>
</head>

<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../estilos/style.css">

<body>
  <link rel="stylesheet" href="../estilos/style.css">
  <!-- HEADER DE INFORMAÇÕES -->
  <header class="header">
    <nav>
      <ul class="list-header">
          <!-- PACIENTES -->
          <a class="btn" href="../Pacientes_Lab/listagem_pacientes.php">Listagem Pacientes</a></li>
        <li>
          <!-- USUÁRIOS -->
          <a class="btn" href=" ../Usuarios_Lab/listagem_usuarios.php">Configurações de usuários</a></li>
        <li>
          <!-- EXAMES -->
          <a class="btn" href="../Exames_Lab/listagem_exames.php">Cadastro de exames</a></li>
        <li>
          <!-- SAIR -->
          <a class="btn" href="../Loguin_Lab/logout.php">Encerrar</a>
        </li>
      </ul>
    </nav>
  </header>
  <!-- MODAL CADASTRADO DE PACIENTES -->
  <div class="container-modal" id="container-modal">
    <div class="janela-cadastro">
      <form action="../Pacientes_Lab/Post.CriarPaciente.php" method=POST>
        <ul class=" lista-cadastro">
          <button class="close">x</button>
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
            <button class="btn-cadastro" type="submit" name="cadastrar">Enviar</button>
          </li>
        </ul>
      </form>
    </div>
  </div>
  <!-- FINAL MODAL CADASTRO DE PACIENTES -->


  <!-- TABELA DE PACIENTES CADASTRADOS -->
  <div class="container">
    <div class="container_son">
      <table cellpadding="10">
        <thead>
          <th>
          <button class="btn-cadastro" id="AbrirModal">Cadastrar Paciente</button>
          </th>
          <th colspan="9">
            <h1>LISTAGEM DE PACIENTES</h1>
          </th>
        </thead>
        <thead>
          <th>Atendimento</th>
          <th>Nome</th>
          <th>Endereço</th>
          <th>Sexo</th>
          <th>E-mail</th>
          <th>Celular</th>
          <th>Nascimento</th>
          <th>Data de cadastro</th>
          <th>Ações</th>
        </thead>
        <tbody>
          <?php if($num_pacientes == 0) { ?>
          <tr>
            <td colspan="7">Nenhum paciente foi encontrado!</td>
          </tr><?php }
                    else{ 
                        while($pacientes = $query_pacientes->fetch_assoc()){
                            $telefone = "Não informado!";
                            // SE O CAMPO CONSULTADO NÃO TIVER VÁZIO, UTILIZARÁ FUNÇÃO PARA FORMATAR O MESMO COM CARACTERES
                            if(!empty($pacientes['telefone'])){
                                $telefone = formatar_telefone($pacientes['telefone']);   
                            }

                            $nascimento = "Nascimento não informada!";
                            // SE O CAMPO CONSULTADO NÃO TIVER VÁZIO, UTILIZARÁ FUNÇÃO QUE PEGA O CAMPO SQL ANO-MES-DIA ALTERANDO - POR / E REVERTER OS CAMPOS PARA DIA/MES/ANO 
                            if(!empty($pacientes['nascimento'])){
                                $nascimento = formatar_data($pacientes['nascimento']);
                            }
                            // FUNÇÃO DATE (PADRÃO DO PHP) PARA CONVERTER DATA DE CADASTRO NO SQL PARA DIA/MES/ANO E HORA
                            $data_cadastro = date("d/m/y H:i:s", strtotime($pacientes['data']));?>
          <tr>
            <td><?php echo $pacientes['ID']?> </td>
            <td><?php echo $pacientes['nome']?> </td>
            <td><?php echo $pacientes['endereco']?> </td>
            <td><?php echo $pacientes['sexo']?> </td>
            <td><?php echo $pacientes['email']?> </td>
            <td><?php echo $telefone; ?> </td>
            <td><?php echo $nascimento ?> </td>
            <td><?php echo $data_cadastro;?> </td>
            <td>
              <a class="edit" href="editar_paciente.php?id=<?php echo $pacientes['ID']?>">Editar</a><hr>
              <a class="error" href="../Pacientes_Lab/deletar_paciente.php?id=<?php echo $pacientes['ID']?>">Deletar</a>
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
  <!-- FINAL TABELA DE PACIENTES -->

  <script src="../src/script.js"></script>
</body>

</html>