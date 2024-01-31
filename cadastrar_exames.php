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
                        unset($_POST);
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
    <title>Exames</title>
</head>
<!-- CÓDIGOS CSS -->
<style>

</style>
<link rel="stylesheet" href="../Arquivos CSS/modal.css">

<!-- JANELA MODAL->CADASTRO DE EXAMES NO SISTEMA -->
<body> 
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button><br>
            <form action="" method="POST">
                <p>Cadastrar exame⤵</p>
                <label>Código exame</label><br><br>
                <input type="text" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" name="codigo"><br><br>
    
                <label>Descrição exame</label></label><br><br>
                <input type="text" value="<?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?>" name="descricao"><br><br>
    
                <button type="submit" name="cadastrar">Cadastrar exame</button>
            </form>
        </div>
    </div>    

    <!-- DIV PARA TABELA COM INFORMAÇÕES DOS EXAMES -->
    <div class="janela_tabela">
        <div>
            <a href="index_login.php"><button class="button1">Pagina inicial</button> </a>
            <button class="button1" onclick="abrir_modal()">Cadastrar exames</button>
        </div>
        
        <h1>Exames</h1>
        <?php 
        if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
        if($error){echo '<p class="error">'. $error . '</p>' ;}   
        ?>
        <table cellpadding="10">
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

<script src="../Arquivos JS/script.js"></script>

</body>
</html>
