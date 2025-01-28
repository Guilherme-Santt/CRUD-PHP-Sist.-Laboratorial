<?php 
// VERIFICAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: index.php");
    }    
}
include('../Control/conexao.php');
include('../Control/function.php');
$id     = intval($_GET['id']);
$sucess  = "";
$error  = "";


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
      $error = "Todos Campos são obrigatórios";
    
  // VERIFICAÇÃO SE O NOME TEM DE 3 Á 100 DÍGITOS
  if(Strlen($nome) < 3 || Strlen($nome) > 100)
      $error = "Nome incorreto";
    
  // VERIFICAÇÃO DE FILTRO DE E-MAIL
  if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
      $error = "E-mail inválido";

  // VERIFICAÇÃO SE DATA DE NASCIMENTO É DIFERENTE DE 10 DÍGITOS
  if(strlen($nascimento) != 10)
      $error = "Data de nascimento inválida";
    
  // VERIFICAÇÃO SE O INPUT TELEFONE NÃO TEM 11 DÍGITOS
  if(strlen($telefone) != 11)
      $error = "Telefone incorreto";
  
  // INSERÇÃO CAMPO EXAME NA TABELA PACIENTES_EXAMES
  if(!empty($codigo)){
      // VERIFICAÇÃO SE O EXAME EXISTE NA TABELA EXAMES
      $sql_verify = "SELECT * FROM exames WHERE codigo = '$codigo'";
      $query_verify = $mysqli->query($sql_verify);
      $verify_existencia_exame = $query_verify->fetch_assoc();
      $codigo = isset($verify_existencia_exame['exameid']) ? $verify_existencia_exame['exameid'] : null;
      if($verify_existencia_exame){
              // VERIFICANDO SE O EXAME JÁ ESTÁ INSERIDO NO PACIENTE NA TABELA PACIENTES_EXAMES
              $sql_verify = "SELECT * FROM pacientes_exames WHERE exame_id = '$codigo' AND paciente_id = '$id' ";
              $query_verify = $mysqli->query($sql_verify);
              $verify_cadastro_exame_no_paciente = $query_verify->fetch_assoc();
              // VERIFICAÇÃO SE  EXAME JÁ ESTÁ INSERIDO
                if($verify_cadastro_exame_no_paciente){
                    $error = "Paciente já contém o exame cadastrado";
                    }
                    else{
                      // SE NÃO ESTIVER INSERIDO, VAI INSERIR
                        $ql_insert = "INSERT INTO pacientes_exames (paciente_id, exame_id) VALUES ('$id', '$codigo')";
                        $query_insert = $mysqli->query($ql_insert);
                    }
          }else{
            // SE O EXAME NÃO EXISTIR, VAI RETORNAR ERRO
            $error = "Exame inexistente";
          }
    }
    // FINAL INSERÇÃO EXAME NA TABELA PACIENTES_EXAMES

    
    if($error){
      
    } else{  //ATUALIZAÇÃO DAS INFORMAÇÕES ALTERADAS
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
                $sucess = "Atualizado com sucesso";
                // unset($_POST);
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
<!--===============================================================================================-->	
<!-- LINK DOS ARQUIVOS CSS -->
<link rel="stylesheet" href="../estilos/style.css">
<!--===============================================================================================-->	
<!-- BIBLIOTECA SWEET MODAL -->
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<body>
    <!-- !-- DIVISÃO Á BAIXO DO HEADER, PARA INFOS & AVISOS  -->
    <header class=" header">
        <nav>
            <ul class="list-header">
                <!-- PACIENTES -->
                <li>
                    <a class="btn" href="listagem_pacientes.php">Listagem Pacientes</a>
                </li>
                <!-- USUÁRIOS -->
                <li>
                    <a class="btn" href="listagem_usuarios.php">Configurações de usuários</a>
                </li>
                <!-- EXAMES -->
                <li>
                    <a class="btn" href="listagem_exames.php">Cadastro de exames</a>
                </li>
                <li>
                    <!-- SAIR -->
                    <a class="btn" href="Login_Lab/logout.php">Encerrar</a>
                </li>

            </ul>
        </nav>
    </header>

    <!-- INSERÇÃO CAMPOS POST NO FORM PARA ATUALIZAÇÃO DE DADOS-->
    <div class="container">
        <div class="att-infos">
            <form action="" method="POST">
                <ul>
                    <h2>Paciente: <?php echo $cliente['nome'];?></h2>
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
                        <input value="<?php echo $cliente['CPF']; ?>" placeholder="CPF do paciente" type="text"
                            name="CPF">
                    </li>

                    <li>
                        <label>Endereço.......:</label>
                        <input value="<?php echo $cliente['endereco']; ?>" type="text" name="endereco">
                    </li>
                    <li>
                        <label>Cidade..........:</label>
                        <input value="<?php if(!empty($cliente['cidade'])){ echo $cliente['cidade'];} ?>" type="text"
                            name="cidade">
                    </li>
                    <li>
                        <label>CEP..............:</label>
                        <input value="<?php if(!empty($cliente['CEP'])){ echo $cliente['CEP'];} ?>" type="text"
                            name="CEP">
                    </li>
                    <li>
                        <label>E-mail..........:</label>
                        <input value="<?php if(!empty($cliente['telefone'])){ echo ($cliente['email']);} ?>"
                            type="email" name="email">
                    </li>
                    <li>
                        <label>Telefone.......:</label>
                        <input value="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>"
                            placeholder="11988888888" type="text" name="telefone">
                    </li>
                    <li>
                        <label>Nascimento..:</label>
                        <input value="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>"
                            placeholder="dia/mês/ano" type="date" name="nascimento">
                    </li>

                    <div clas="exames-paciente">
                        <div>
                            <?php if($num_exames == 0) {?>
                            <!-- MENSAGEM CASO NÃO TIVER NENHUM EXAME CADASTRADO -->
                            <p>Nenhum exame foi encontrado!</p>
                            <?php } ?>

                            <!-- CÓDIGO DOS EXAMES INSERIDOS NO PACIENTE -->
                            <p>Exames cadastrados:</p>
                            <?php while($exames = $query_exames->fetch_assoc()){?>
                            <button class="remover-exame-paciente">
                                <a href="../modules/remover_exame_paciente.php?id=<?php echo $exames['id']?>">
                                    <?php echo $exames['codigo']?> </a>
                            </button> <?php }?>
                        </div>
                    </div>
                    <li>
                        <p>Adicionar um exame no atendimento:</p>
                        <label>Exame ID</label>
                        <input type="text" name="id_exame">
                    </li>
                    <button class="btn-cadastro" type="submit">Enviar</button>
                </ul>
            </form>
        </div>

        <!-- SWEET ALERTA PARA ERRO OU SUCESSO -->
        <?php
      if(isset($error) && $error) :?>
        <script>
        Swal.fire({
            icon: 'error',
            title: '<?php echo $error; ?>',
            // text: 'Verifique o campo preenchido',
            confirmButtonText: 'Fechar'
        });
        </script>
        <?php endif;?>
        <?php
      if(isset($sucess) && $sucess) :?>
        <script>
        Swal.fire({
            icon: 'success',
            title: '<?php echo $sucess; ?>',
            // text: '',
            confirmButtonText: 'fechar'
        });
        </script>
        <?php endif;?>
</body>
<script src="./src/script.js"></script>
<script src="../src/script.js"></script>

</html>