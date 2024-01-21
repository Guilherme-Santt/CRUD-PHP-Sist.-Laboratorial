<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
include('conexao.php');
$id = $_SESSION['usuario'];

// QUANTIDADE E INFORMAÇÕES D EUSUARIOS
$sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
$query = $mysqli->query($sqlcode);
$cont_user = $query->num_rows;
$usuario = $query->fetch_assoc();

// QUANTIDADE E INFORMAÇÕES DE PACIENTES
$sqlcode = "SELECT * FROM pacientes";
$query = $mysqli->query($sqlcode);
$cont_pacientes = $query->num_rows;

// QUANTIDADE E INFORMAÇÕES DE EXAMES
$sqlcode = "SELECT * FROM exames";
$query = $mysqli->query($sqlcode);
$cont_exames = $query->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela inicial</title>    
</head>
<link rel="stylesheet" href="../Arquivos CSS/inicial.css">
<link rel="stylesheet" href="../Arquivos CSS/normalize.css">
<link rel="stylesheet" href="../Arquivos CSS/modal.css">


<body >
    <!-- Header  *NAV* - Mensagem central superior -->
    <div class="h-g">
        <form class="h-f">
            <p class="white">Usuário: <b><?php echo $usuario['nome']?></b></p>
        </form>

        <!-- *HEADER* Menu -->
        <img onclick="lmenu()" class="h-img" src="../imagens/hamburger.png">
        <div id="lh" class="h-menu"><br>
            <a onclick="fmenu()">X</a>
            <Ul> 
                <a href="usuarios.php"><li>Usuários</li></a>
                <a href="pacientes.php"><li>Atendimentos</li></a>
                <a href="exames.php"><li>Exames</li></a>
                <a href="logout.php"><li>Encerrar sessão</li></a>
            </Ul>
        </div>
        <p class="white">Unidade: <b><?php echo $usuario['unidade']?></b></p>
    </div>
<!-- DIVISÃO MENU DE SELEÇÕES INICIAL -->
    <div class="select-inic">
            <div class="select">
                <h1>Atendimentos⤵ </h1>
                <a href="pacientes.php"><img src="../imagens/modeloatendimento.jpg"></a>
            </div>
            <div class="select">
                <h1>Usuários⤵</h1>
                <a href="usuarios.php"> <img src="../imagens/modelousuarios.jpg"></a>
            </div>
            <div class="select">
                <h1>Sugestões⤵</h1>
                <img onclick="abrir_modal()" src="../imagens/modelo2.jpg">
            </div>
            <div class="janela-modal" id="janela-modal">
                <div class="modal">
                <button class="fechar" id="fechar">X</button>
                <p>Envie sugestões para automação de suas operações⤵</p>
                </div>
            </div>
    </div>
<!-- DIVISÃO RODA PÉ DE INFORMAÇÕES -->
    <div class="rodape">
        </div>
        <div class="consult">
            <p>Qnt. usuários cadastrados: <?php echo $cont_user ?></p>
            <p>Qnt. pacientes cadastrados: <?php echo $cont_pacientes ?></p>
            <p>Qnt. exames cadastrados: <?php echo $cont_exames ?></p>
        </div>
        <div class="redes">
            <p>@SYSTEMLOCAL</p> 
            <img src="../imagens/facebook.png">
            <img src="../imagens/instagram.png">
            <img src="../imagens/tiktok.png">
            <img src="../imagens/whatsapp.png">
            <img src="../imagens/youtube.png">
            <img src="../imagens/o-email.png">
    </div>

<script src="../Arquivos JS/script.js"></script>
<script src="../Arquivos JS/index.js"></script>
</body>
</html>
