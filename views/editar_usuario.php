<?php 
// SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../Control/function.php');
include('conexao.php');
include('../Control/SelectFrom.php');
$id = intval($_GET['id']);

$alert = "";
if(count($_POST) > 0){
    $authorization = $_POST['authorization'];
        if(!isset($authorization))
            $alert ="ERROR";

    $nome = $_POST['nome'];
        if(empty($nome))
            $alert = "CAMPO VÁZIO";
    $email = $_POST['email'];
        if(empty($email))    
            $alert = "CAMPO VÁZIO";
    $unidade = $_POST['unidade'];
        if(empty($unidade))
            $alert = "CAMPO VÁZIO";
    $telefone = $_POST['telefone'];
        if(empty($telefone))
            $alert = "CAMPO VÁZIO";
    $nascimento = $_POST['nascimento'];
        if(empty($nascimento))
            $alert = "CAMPO VÁZIO";

    if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $alert = "CAMPO NOME INVÁLIDO OU INCORRETO ";
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $alert = "CAMPO E-MAIL INVÁLIDO OU INCORRETO.";
    if(empty($nascimento) || strlen($nascimento) != 10)
        $alert = "CAMPO NASCIMENTO INCORRÉTO";
        
    if(empty($telefone) || strlen($telefone) != 11)
        $alert ="CAMPO TELEFONE INVÁLIDO OU INCORRÉTO";

    if($alert){
        die($alert);
    }
     else{
        $sql_code = "UPDATE clientes
        SET nome   = '$nome', 
        email      = '$email',
        unidade    = '$unidade',
        telefone   = '$telefone',
        nascimento = '$nascimento' WHERE id   = '$id'";
        $deu_certo = $mysqli->query($sql_code);
            if($deu_certo){
                echo  "<script>alert('ATUALIZADO COM SUCESSO');</script>";
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
<link rel="stylesheet" href="../css/modal.css">
<link rel="stylesheet" href="../css/index.css">
<link rel="stylesheet" href="../css/button.css">

<body>
    <div class="body-header">
        <div class="seletc_g">
            <div class="select_header">
                <div>
                    <a href="../views/index.php"><img class="icon_select" src="../icons/monitor (2).png">
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
                    <a href="listagem_exames.php"><img class="icon_select" src="../icons/grafico.png"></a>
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
                <a href="../Control/logout.php"><img class="icon_select" src="../icons/fracassado.png"></a>
                </div>
                <div>
                    <h3>
                        Encerrar
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- !-- DIVISÃO Á BAIXO DO HEADER, PARA INFOS & AVISOS  -->
    <div class="Bottom_header">
        
    </div>

    <div class="container_body">
        <div class="container_son"> 
            <form action="" method="POST">
                <label>Nome:</label>
                <input value= "<?php echo $cliente['nome']; ?>" type="text" name="nome">

                <label>E-mail:</label>
                <input value ="<?php echo $cliente['email']; ?>" type="email" name="email">

                <label>Unidade:</label>
                <input value ="<?php echo $cliente['unidade']; ?>" type="text" name="unidade">

                <label>Telefone:</label>
                <input value ="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>" type="text" name="telefone">

                <label>Data de nascimento:</label>
                <input value ="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>" type="date" name="nascimento">
                <?php 
                if(isset($error)){ echo $error;} 
                if(isset($sucess)){ echo $sucess;}
                ?>
                <button class="btn_style" name="authorization" type="submit">Atualizar</button>
            </form>
            
            <button onclick="abrir_modal()" class="btn_style">Assinatura</button>
            <a href="listagem_usuarios.php"><button class="btn_style">Retornar</button></a>
            <a href="index.php"><button class="btn_style">Welcome</button></a>

            <div class="janela-modal" id="janela-modal">
                <div class="modal" >
                    <button class="fechar" id="fechar">X</button><br>

                    <form enctype="multipart/form-data" action="../Control/Post_InserirAssinatura.php" method="POST">
                        <label>Assinatura</label>
                        <input type="file" name="signature"><br><br>
                        <buttton class="btn_style" type="submit">Enviar</buttton>
                    </form>

                </div>
            </div>
        <div>
    </div>       
<script src="../src/modal.js"></script> 
</body>
</html>

