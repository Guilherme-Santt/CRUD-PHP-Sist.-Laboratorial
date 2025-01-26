<?php
include('Control/conexao.php');
// VERIFICAÇÃO POST Á PARTIR DO EMAIL
$error = "";
if(isset($_POST['email']) ){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // VERIFICAÇÃO SE OS CAMPOS ESTÃO VAZIOS
    if(empty($email) || empty($senha)){
      $error = "E-mail ou senha incorretos";
    }
    // VERIFICAÇÃO SE EXISTE O USUÁRIO NO BANCO
    else{
        $sql_code = "SELECT * FROM clientes WHERE email = '$email' LIMIT 1";
        $sql_exec = $mysqli->query($sql_code);
        $usuario = $sql_exec->fetch_assoc();
        if (!$usuario) {
            $error = "Usuário não cadastrado";    
        }
        else {
          // VERIFICAÇÃO SE A SENHA BATE COM A SENHA DO BANCO->SESSION OU MENSAGEM DE ERRO
          if(password_verify($senha, $usuario['senha'] )){
            if(!isset($_SESSION)){
              session_start();
              $_SESSION['usuario'] = $usuario['id'];
              header("location: listagem_pacientes.php");
            }
          }else{
              $error = "Usuário ou senha incorretos";
          }
        }
      }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
</head>

<!-- BIBLIOTECA SWEET MODAL -->
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<body>
    <div class="full_mapa">
        <form action="" method="POST">
            <ul>
                <li>

                    <label>Usuário</label>
                    <input type="email" name="email">
                </li>
                <li>
                    <Label>Senha</Label>
                    <input type="password" name="senha">
                </li>
                <li>
                    <button class="btn_style" type="submit">Entrar</button>
                </li>
            </ul>
        </form>
    </div>


    <!-- SWEET ALERTA PARA ERRO OU SUCESSO -->
    <?php
      if(isset($error) && $error) :     ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: '<?php echo $error; ?>',
        text: 'Verifique o campo preenchido',
        confirmButtonText: 'Fechar'
    });
    </script>
    <?php endif;?>

</body>

</html>