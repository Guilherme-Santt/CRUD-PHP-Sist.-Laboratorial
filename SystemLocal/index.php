<?php
include('../conexao/conexao.php');
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}

$id = $_SESSION['usuario'];

// INFORMAÇÕES DE USUARIOS
$sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
$query = $mysqli->query($sqlcode);
$usuario = $query->fetch_assoc();

// QUANTIDADE DE USUARIOS
$sqlcode = "SELECT * FROM clientes WHERE id";
$query = $mysqli->query($sqlcode);
$usuario = $query->fetch_assoc();
$cont_user = $query->num_rows; 

// QUANTIDADE E INFORMAÇÕES DE PACIENTES
$sqlcode = "SELECT * FROM pacientes";
$query = $mysqli->query($sqlcode);
$cont_pacientes = $query->num_rows;

// QUANTIDADE E INFORMAÇÕES DE EXAMES
$sqlcode = "SELECT * FROM exames";
$query = $mysqli->query($sqlcode);
$cont_exames = $query->num_rows;

// POST PARA ENVIO DE SUGESTÕES
if(isset($_POST['sugestao'])){
    $error = "";
    $sugestao = $_POST['sugestao'];
    if(empty($_POST['sugestao'])){
        $error = "Campo obrigatório*";
    }
    if($error){

    }else{
    $enviado = "";
    $sql_code = "SELECT * FROM sugestoes WHERE sugestao = '$sugestao'";
    $query = $query_sug = $mysqli->query($sql_code);
    $consulta_sugestao = $query->fetch_assoc();
    
        if($consulta_sugestao){
            echo "<script>alert('Sugestão já enviada. Caso tiver outra sugestão, será um prazer avaliar!');</script>";
        }
        else{
            $sql_code = "INSERT INTO sugestoes (id_user, sugestao) VALUES ('$id', '$sugestao')";
            $query_sug = $mysqli->query($sql_code);
            if($query_sug){
                echo "<script>alert('Sugestão enviada com sucesso! Iremos avaliar a possibilidade e dare mos retorno no email cadastrado. Obrigado.');</script>";
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
    <title>Tela inicial</title>    
</head>

<link rel="stylesheet" href="../Arquivos CSS/modal.css">
<link rel="stylesheet" href="../Arquivos CSS/button.css">
<link rel="stylesheet" href="./css/style.css">

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
                <p>Local System <b><?php echo $usuario['unidade']?></b></p>
                <a href="../index_usuarios/usuarios.php"><li>Usuários</li></a>
                <a href="../index_pacientes/pacientes.php"><li>Atendimentos</li></a>
                <a href="../index_exames/exames.php"><li>Exames</li></a>
                <a href="../index_login/logout.php"><li>Encerrar sessão</li></a>
            </Ul>
        </div>
        <p class="white">Unidade: <b><?php echo $usuario['unidade']?></b></p>
    </div>
<!-- DIVISÃO MENU DE SELEÇÕES INICIAL -->
    <div class="select-inic">
            <div class="select">
                <h1>Atendimentos⤵ </h1>
                <a href="../index_pacientes/pacientes.php"><img src="../imagens/modeloatendimento.jpg"></a>
            </div>
            <div class="select">
                <h1>Usuários⤵</h1>
                <a href="../index_usuarios/usuarios.php"> <img src="../imagens/modelousuarios.jpg"></a>
            </div>
            <div class="select">
                <h1>Sugestões⤵</h1>
                <img onclick="abrir_modal()" src="../imagens/modelo2.jpg">
            </div>
            <div class="janela-modal" id="janela-modal">
                <div class="modal">
                    <button class="fechar" id="fechar">X</button>
                        <form method="post">
                            <br><p>Envie sugestões para automação de suas operações⤵</p><br>
                            <textarea ows="50" cols="40" name="sugestao"></textarea><br>
                            <button class="button1" type="submit">Enviar</button>
                            <?php if(isset($error)){ echo $error;}?>
                        </form>
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
