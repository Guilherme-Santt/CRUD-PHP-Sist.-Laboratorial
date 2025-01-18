<?php 
include('../views/conexao.php');
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
<link rel="stylesheet" href="../css/button.css">

<body>

  <!-- TABELA DE PACIENTES CADASTRADOS -->
  <div class="container_body">
    <div class="container_son">
      <div>
        <a href="Criar_Paciente.php"><button class="btn_style">Cadastro Completo</button></a>

      </div><br>
      <p>Seus pacientes cadastrados</p>
      <table cellpadding="10">
        <thead>
          <th>Atendimento</th>
          <th>Nome</th>
          <th>Endereço</th>
          <th>Sexo</th>
          <th>E-mail</th>
          <th>Celular</th>
          <th>Nascimento</th>
          <th>Convênio</th>
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
            <td><?php if(!empty($pacientes['Convenio'])){echo $pacientes['Convenio'];}else{ echo "Convênio não informado";}?> </td>
            <td><?php echo $data_cadastro;?> </td>
            <td>
              <a class="edit" href="editar_paciente.php?id=<?php echo $pacientes['ID']?>">Editar</a>
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
  <script src="../src/modal.js"></script>
</body>

</html>