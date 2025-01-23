<?php 
// VERIFICAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../loguin_Lab/index_login.php");
    }    
}
include('../Control/conexao.php');
$id     = intval($_GET['id']);
$alert  = "";

if(count($_POST) > 0){
    $nome         = $_POST['nome'];
    $email        = $_POST['email'];
    $endereco     = $_POST['endereco'];
    $telefone     = $_POST['telefone'];
    $nascimento   = $_POST['nascimento'];
    $codigo       = $_POST['id_exame'];
    $RG           = $_POST['RG'];
    $CPF          = $_POST['CPF'];
    $CEP          = $_POST['CEP'];
    $cidade       = $_POST['cidade'];
    
    // VERIFICAÇÕES DE SEGURANÇA DOS INPUTS 
    if(empty($RG) || empty($CPF) || empty($cidade) || empty($CEP) || empty($cidade) || empty($nome) ||  empty($nascimento) || empty($telefone)) 
        $alert = "Todos Campos são obrigatórios";

    if(Strlen($nome) < 3 || Strlen($nome) > 100)
        $alert = "NOME INCORRETO";

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $alert = "CAMPO E-MAIL INCORRETO";

    if(strlen($nascimento) != 10)
        $alert = "DATA DE NASCIMENTO INCORRETA";

    if(strlen($telefone) != 11)
        $alert = "TELEFONE INCORRETO";
    
    // INSERÇÃO CAMPO EXAME NA TABELA PACIENTES_EXAMES
    if(!empty($codigo)){
        // VERIFICAÇÃO SE O EXAME EXISTE NA TABELA EXAMES
        $sql_verify = "SELECT * FROM exames WHERE exameid = '$codigo'";
        $query_verify = $mysqli->query($sql_verify);
        $verify_existencia_exame = $query_verify->fetch_assoc();
        if($verify_existencia_exame){
                $sql_verify = "SELECT * FROM pacientes_exames WHERE exame_id = '$codigo' AND paciente_id = '$id' ";
                $query_verify = $mysqli->query($sql_verify);
                $verify_cadastro_exame_no_paciente = $query_verify->fetch_assoc();
                        if($verify_cadastro_exame_no_paciente){
                            $alert = "EXAME JÁ INSERIDO";
                            }
                            else{
                                $ql_insert = "INSERT INTO pacientes_exames (paciente_id, exame_id) VALUES ('$id', '$codigo')";
                                $query_insert = $mysqli->query($ql_insert);
                            }
                        }else{
                            $alert = "EXAME INEXISTENTE";
                        }
                    }    
    else{  // ATUALIZAÇÃO DAS INFORMAÇÕES ALTERADAS
        $sql_code = "UPDATE pacientes
        SET nome     = '$nome', 
        endereco     = '$endereco',
        RG           = '$RG',
        CEP          = '$CEP',
        CPF          = '$CPF',
        cidade       = '$cidade',
        email        = '$email',
        telefone     = '$telefone',
        nascimento   = '$nascimento' WHERE id  = '$id'";
        $deu_certo = $mysqli->query($sql_code);
            if($deu_certo){
                $alert = "ATUALIZADO COM SUCESSO";
                unset($_POST);
            }
    }
}

// VISUALIZAÇÃO INFORMAÇÕES USUÁRIO NO CAMPO EDIÇÃO
$sql_cliente = "SELECT * FROM pacientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

// CAMPOS EXAMES DO PACIENTE / ID DO EXAME / ID DO PACIENTE
$sql_exame = "SELECT * FROM pacientes_exames AS pacex
    INNER JOIN exames ON exames.exameid = pacex.exame_id WHERE pacex.paciente_id = '$id'";
$query_exames = $mysqli->query($sql_exame);
$num_exames = $query_exames->num_rows;

 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informações do paciente</title>
</head>

<!-- LINK DOS ARQUIVOS CSS -->
<link rel="stylesheet" href="../estilos/style.css">

<body>

  <!-- !-- DIVISÃO Á BAIXO DO HEADER, PARA INFOS & AVISOS  -->
  <header class=" header">
    <nav>
      <ul class="list-header">
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
        <li>
        <!-- SAIR -->
        <a class="btn" href="../Loguin_Lab/logout.php">Encerrar</a>
        </li>

      </ul>
    </nav>
  </header>

  <!-- INSERÇÃO CAMPOS POST NO FORM PARA ATUALIZAÇÃO DE DADOS-->
  <div class="container_body">
    <div class="att-infos">
      <p>Informações do paciente:</p>
      <form action="" method="POST">
        <ul>
          <li>
            <label>Nome............: </label>
            <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome">
          </li>
          <li>
            <label>RG................: </label>
            <input value="<?php echo $cliente['RG']; ?>" placeholder="RG do paciente" type="text" name="RG">
          </li>
          <li>
            <label>CPF...............: </label>
            <input value="<?php echo $cliente['CPF']; ?>" placeholder="CPF do paciente" type="text" name="CPF">
          </li>

          <li>
            <label>Endereço.......:</label>
            <input value="<?php echo $cliente['endereco']; ?>" type="text" name="endereco">
          </li>
          <li>
            <label>Cidade..........:</label>
            <input value="<?php if(!empty($cliente['cidade'])){ echo $cliente['cidade'];} ?>" type="text" name="cidade">
          </li>
          <li>
            <label>CEP..............:</label>
            <input value="<?php if(!empty($cliente['CEP'])){ echo $cliente['CEP'];} ?>" type="text" name="CEP">
          </li>
          <li>
            <label>E-mail..........:</label>
            <input value="<?php if(!empty($cliente['telefone'])){ echo ($cliente['email']);} ?>" type="email" name="email">
          </li>
          <li>
            <label>Telefone.......:</label>
            <input value="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>" placeholder="11988888888" type="text" name="telefone">
          </li>
          <li>
            <label>Nascimento..:</label>
            <input value="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>" placeholder="dia/mês/ano" type="date" name="nascimento">
          </li>

          <li>
            <p>Adicionar um exame no atendimento:</p>
            <label>Exame ID</label>
            <input type="text" name="id_exame">
          </li>

        <button class="btn-cadastro" type="submit">Enviar</button><br><br>
        </ul>
      </form>
      <?php if(isset($alert)) echo $alert; ?>
    </div>

    <div class="Table-infos">
      <!-- TABELA DE INFORMAÇÕES EXAMES CADASTRADOS DO PACIENTE -->
      <table border="1px" cellpadding="10">
        <thead>
          <th>ID Exames</th>
          <th>código exame</th>
          <th>Nome exame</th>
          <th>Resultado</th>
          <th>Inserir Resultado</th>
          <th>Remover</th>

        </thead>
        <tbody> <?php if($num_exames == 0) {?>
          <tr>
            <td colspan="7">Nenhum exame foi encontrado!</td>
          </tr> <?php } ?>
          <?php while($exames = $query_exames->fetch_assoc()){?>

          <tr>
            <td><?php echo $exames['exame_id']?></td>
            <td><?php echo $exames['codigo']?></td>
            <td><?php echo $exames['descricao']?></td>

            <td><?php if($exames['resultado'] == 0){ }else echo number_format($exames['resultado'], 1, ',', '.')?></td>
            <td><a href="inserir_resultado.php?id=<?php echo $exames['id']?>">inserir</a></td>
            <td><a href="../Pacientes_Lab/remover_exame_paciente.php?id=<?php echo $exames['id']?>">X</a></td>
          </tr><?php }?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>