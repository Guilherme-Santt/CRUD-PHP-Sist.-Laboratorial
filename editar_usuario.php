<?php
// SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: Login_Lab/index_login.php");
    }
}
include('Control/function.php');
include('Control/conexao.php');
$id = intval($_GET['id']);
$error = "";
$sucess = "";


if(count($_POST) > 0){
    $nome       = $_POST['nome'];
    $email      = $_POST['email'];
    $telefone   = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    // VERIFICAÇÃO INPUT NOME SE ESTÁ VAZIO OU SE CONTÉM DE 3 Á 100 DÍGITOS.
    if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $error = "Nome inválido";

    // VERIFICAÇÃO INPUT EMAIL SE ESTÁ VAZIO OU SE ESTÁ SEM FILTRO DE E-MAIL exemplo@exemplo.com.
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email))
        $error = "E-mail inválido";

    // VERIFICAÇÃO INPUT NOME SE ESTÁ VAZIO OU SE CONTÉM DE 3 Á 100 DÍGITOS.
    if(empty($nascimento) || strlen($nascimento)!=10)
        $error = "Data de nascimento inválida";

    // VERIFICAÇÃO INPUT NOME SE ESTÁ VAZIO OU SE CONTÉM DE 3 Á 100 DÍGITOS.
    if(empty($telefone) || strlen($telefone) != 11)
        $error = "Telefone inválido";

    // ATUALIZAÇÃO DE INFORMAÇÕES DO PACIENTE
    if($error){

    }else{
      $sql_code = "UPDATE clientes
      SET nome   = '$nome',
      email      = '$email',
      telefone   = '$telefone',
      nascimento = '$nascimento' WHERE id   = '$id'";
      $deu_certo = $mysqli->query($sql_code);
        if($deu_certo){
          $sucess = "Atualizado com sucesso";
            // header("location: editar_usuario.php?id=$id");

        }
      }
}

// SELECT FROM NA TABELA CLIENTES, PARA PUXAR INFORMAÇÕES DOS PACIENTES PARA OS CAMPOS INPUT
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de usuários</title>
</head>

<!-- ARQUIVOS CSS SITE -->
<link rel="stylesheet" href="estilos/style.css">
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<body>
    <!-- HEADER DE INFORMAÇÕES -->
    <header class="header">
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
    <!-- END HEADER -->

    <!-- CONTAINER DE ATUALIZAÇÃO DE INFORMAÇÕES DO PACIENTE. A BAICO CONTÉM TODOS INPUTS PARA ATUALIZAR -->
    <div class="container">
        <div class="container_son">
            <form action="" method="POST">
                <ul class="lista-cadastro">
                    <li>
                        <h1>
                            Edição do usuário <?php echo $cliente['nome'] ?>
                        </h1>
                    </li>
                    <li>
                        <label>Nome:</label>
                        <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome">
                    </li>
                    <li>
                        <label>E-mail:</label>
                        <input value="<?php echo $cliente['email']; ?>" type="email" name="email">
                    </li>
                    <li>
                        <label>Telefone:</label>
                        <input value="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>"
                            type="text" name="telefone">
                    </li>
                    <li>
                        <label>Data de nascimento:</label>
                        <input value="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>"
                            type="date" name="nascimento">
                    </li>

                    <li>
                        <button class="btn_style" name="authorization" type="submit">Atualizar</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <!-- FIM CONTAINER DE ATUALIZAÇÕES -->

    <!-- SWEET ALERTA PARA ERRO OU SUCESSO -->
    <?php
    if(isset($error) && $error) :?>
    <script>
    Swal.fire({
        icon: 'error',
        title: '<?php echo $error; ?>',
        text: 'Verifique o campo preenchido',
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

</html>