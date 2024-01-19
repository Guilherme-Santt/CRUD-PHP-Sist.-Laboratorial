<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
include('conexao.php');
$id = $_SESSION['usuario'];

$error = "";
$sucess = "";
// VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
if(count($_POST) > 0){
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    // VERIFICANDO SE O CAMPO DESCRIÇÃO ESTÁ VAZIO
    if(empty($_POST['descricao'])){
        $error = "Campo descrição obrigatório*";
    }  
    // VERIFICANDO SE O CAMPO CÓDIGO ESTÁ VAZIO OU MAIOR QUE 3 DÍGITOS
    if(empty($_POST['codigo']) || Strlen($codigo) > 3){
        $error = "Campo código deve conter 3 dígitos";
    }
    // VERIFICANDO SE CONTÉM ALGUM ERRO-.> CASO TIVER TERÁ UM IF ISSET ERRO A BAIXO DO FORM
    if($error){

    }
    // VERIFICAÇÃO SE O POST CÓDIGO EXISTE NO BANCO DE DADOS, PARA NÃO DUPLICAR EXAME AO CRIAR
    else{
        $sql_codeverify = "SELECT * FROM exames WHERE codigo = '$codigo'";
        $query_c = $mysqli->query($sql_codeverify);
        $verify = $query_c->fetch_assoc();
            if($verify){
                $error = "Código exame já cadastrado!";
            }
        // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR O CÓDIGO 
            else{
                $sqlinsert = "INSERT INTO exames (descricao, codigo)  values ('$descricao', '$codigo')";
                $queryinsert = $mysqli->query($sqlinsert);
                    if($queryinsert){
                        $sucess = "Cadastrado com sucesso";
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
    <title>Document</title>
</head>
<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../Arquivos CSS/normalize.css">
<link rel="stylesheet" href="../Arquivos CSS/button.css">
<link rel="stylesheet" href="../Arquivos CSS/tabela.css">
<link rel="stylesheet" href="../Arquivos CSS/efeito_a.css">
<link rel="stylesheet" href="../Arquivos CSS/modal.css">
<link rel="stylesheet" href="../Arquivos CSS/input.css">
<link rel="stylesheet" href="../Arquivos CSS/janela_tabela.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Roboto+Condensed:ital,wght@1,200;1,300;1,400&display=swap" rel="stylesheet">

<!-- JANELA MODAL->CADASTRO DE EXAMES NO SISTEMA -->
<body> 
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button><br>
            <form action="" method="POST">
                <label>Código exame</label>
                <input class="input_edit" type="text" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" name="codigo"><br><br>
    
                <label>Descrição exame</label>
                <input class="input_edit" type="text" value="<?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?>" name="descricao"><br><br>
    
                <button class="button_slide" type="submit" name="cadastrar">Cadastrar exame</button>
            </form>
        </div>
    </div>    

    <div class="janela-tabela">
    <!-- DIV PARA TABELA COM INFORMAÇÕES DOS EXAMES -->
    <div class="janela_tabela">
        <h1>Esses são os exames cadastrados no seu sistema</h1>
        <button><a href="index.php">Pagina inicial</button> </a> 
        <button onclick="abrir_modal()">Cadastrar exames</button>
        <table border="1" cellpadding="10">
            <thead>
                <th>ID exame</th>
                <th>Código exame</th>
                <th>Descrição exame</th>
                <th>Deletar exame</th>
            </thead>
            <tbody> 
            <?php 
            // COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
            $sql_exames  = "SELECT * FROM exames";
            $query_exames = $mysqli->query($sql_exames) or die($mysqli->error);
            $num_exames = $query_exames->num_rows;
                if($num_exames == 0) { 
                ?> 
                <tr>
                    <td colspan="3">Nenhum exame foi encontrado!</td>
                </tr>
                <?php }
                    else{ 
                        while($exames = $query_exames->fetch_assoc()){?>     
                    <tr>
                        <td><?php echo $exames['exameid']?>     </td>
                        <td><?php echo $exames['codigo']?>   </td>
                        <td><?php echo $exames['descricao']?>  </td>   
                        <td><a href="deletar_exame.php?id=<?php echo $exames['exameid'] ?>">Deletar exame</a></td>
                    </tr>      
                <?php     }
                    } ?>
            </tbody>
        </table><br>
    </div>
    <?php 
    if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
    if($error){echo '<p class="error">'. $error . '</p>' ;}   
    ?>
<script src="../Arquivos JS/script.js"></script>

</body>
</html>
