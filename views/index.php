<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
include('conexao.php');
$id = $_SESSION['usuario'];

// INFORMAÇÕES DE USUARIOS & QUANTIDADE DE USUARIOS
$sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
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

<link rel="stylesheet" href="../css/modal.css">
<link rel="stylesheet" href="../css/button.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/index.css">

<body >
    <!-- HEADER SUPERIOR -->
    <div class="body-header">
        <div class="seletc_g">
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/monitor (2).png">
                </div>
            </div>
            <div class="select_header">
                <div>
                    <a href="listagem_usuarios.php"><img  class="icon_select" src="../icons/monitor (2).png"></a>
                </div>
                <div>
                    <h3>
                        Usuários
                    </h3>
                </div>
            </div>
            <div class="select_header">
                <div>
                    <a href="../views/listagem_pacientes.php"><img class="icon_select" src="../icons/arquivo (1).png"></a>
                </div>
                <div>
                    <h3>
                        Pacientes
                    </h3>
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/grafico.png">
                </div>
                <div>
                    <h3>
                        Exames
                    </h3>      
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/moeda-de-dolar.png">
                </div>
                <div>
                    <h3>
                        Financeiro
                    </h3>        
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/bate-papo.png">
                </div>
                <div>
                    <h3>
                        Suporte
                    </h3>           
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img onclick="abrir_modal()" class="icon_select" src="../icons/calendario.png">
                </div>
                <div>
                    <h3>
                        Sugestões
                    </h3>
                </div>       
            </div>
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/fracassado.png">
                </div>
                <div>
                    <h3>
                        Encerrar
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="select-inic">
        <!-- MENU DE SUGESTÕES -->
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
    <!-- DIVISÃO Á BAIXO DO HEADER, PARA INFOS & AVISOS -->
    <div class="Bottom_header">
        <p class="white">Usuário: <b><?php echo $usuario['nome']?></b></p>
        <p>Local System <b><?php echo $usuario['unidade']?></b></p>
    </div>
    <!-- DIVISÃO CONTAINER -->
    <div class="container_body">
        <div class="container_son">

        </div>
        <div class="container_son">

        </div>
        <div class="container_son">

        </div>
    </div>

    <!-- DIVISÃO RODA PÉ DE INFORMAÇÕES -->
    <div class="rodape">
        <p>Qnt. usuários cadastrados: <?php echo $cont_user ?></p>
        <p>Qnt. pacientes cadastrados: <?php echo $cont_pacientes ?></p>
        <p>Qnt. exames cadastrados: <?php echo $cont_exames ?></p>
    </div>

<script src="../src/script.js"></script>
</body>
</html>
