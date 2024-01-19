<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
include('conexao.php');
$id = $_SESSION['usuario'];
$sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
$query = $mysqli->query($sqlcode);
$usuario = $query->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial</title>
    <link rel="stylesheet" href="../Arquivos CSS/index.css">
    <link rel="stylesheet" href="../Arquivos CSS/normalize.css">
</head>
<body >
    <!-- Header  *NAV* - Mensagem central superior -->
    <header class="h-g">
        <form class="h-f">
            <p class="white">Usuário: <b><?php echo $usuario['nome']?></b></p>
        </form>
        <!-- *HEADER* Menu & Logo central  -->
        <img onclick="lmenu()" class="h-img" src="../imagens/hamburger.png">
        <div id="lh" class="h-menu"><br>
            <a onclick="fmenu()">X</a>
            <Ul>
                <a href="usuarios.php"><li>Usuários</li></a>
                <a href="pacientes.php"><li>Atendimentos</li></a>
                <a href="exames.php"><li>Cadastro de exames</li></a>
                <a href="logout.php"><li>Encerrar sessão</li></a>
            </Ul>
        </div>
        <p class="white">Unidade: <b><?php echo $usuario['unidade']?></b></p>
    </header>
<script src="../Arquivos JS/index.js"></script>
</body>
</html>
