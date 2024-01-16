<!-- <?php
    include('conexao.php');
    $error = "";
    // VERIFICAÇÃO POST Á PARTIR DO EMAIL
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        if(empty($email)){
            $error = '<p class="error">Preencha o campo email*</p>';
        }
        else if(empty($senha)){
            $error = '<p class="error">Preencha o campo senha*</p>';
        }
        // VERIFICAÇÃO SE EXISTE O USUÁRIO NO BANCO
        else{
            $sql_code = "SELECT * FROM clientes WHERE email = '$email' LIMIT 1";
            $sql_exec = $mysqli->query($sql_code);
            $usuario = $sql_exec->fetch_assoc();
            if (!$usuario) {
                $error = '<p class="error">Usuário inexistente*</p>';    
            }
            else 
            // VERIFICAÇÃO SE A SENHA BATE COM A SENHA DO BANCO->SESSION OU MENSAGEM DE ERRO
            {
                if(password_verify($senha, $usuario['senha'] )){
                    if(!isset($_SESSION)){
                        session_start();
                        $_SESSION['usuario'] = $usuario['id'];
                        header("location: index.php");
                    }
                }else{
                    $error = '<p class="error">Usuário ou senha incorretos!*</p>';
                }
            }
            if($error){
            }
    }
}
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="normalize.css">
</head>
<style>

</style>
<body>
    <div class="full_mapa">    
        <div class="form_login">
            <form class="form_edit" action="" method="POST">
                <h1>logo</h1>
                <label class="edit_label">Usuario</label><br>
                <input class="input_edit" type="email" name="email"><br><br>
                <Label class="edit_label">Senha</Label><br>
                <input class="input_edit"  type="senha" name="senha"><br><br>
                <button type="submit">Logar</button>
                <p>
                    <?php if(isset($error)){echo $error;}?> 
                </p>
            </form>
        </div>
        <div class="img_banner">
        </div>
    </div>
</body>
</html>