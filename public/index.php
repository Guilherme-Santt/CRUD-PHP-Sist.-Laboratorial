<?php
include('../Control/conexao.php');
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
	<title>Login V16</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../estilos/util.css">
	<link rel="stylesheet" type="text/css" href="../estilos/main.css">
<!--===============================================================================================-->
</head>
<body>	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('../images/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Acesso ao sistema
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" action="" method="POST">

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" placeholder="Seu E-mail" type="email" name="email">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password"  placeholder="Senha" name="senha">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit">
							Entrar
						</button>
					</div>

				</form>
			</div>
		</div>
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
<!--===============================================================================================-->
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/daterangepicker/moment.min.js"></script>
	<script src="../vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../src/main.js"></script>

</body>
</html>