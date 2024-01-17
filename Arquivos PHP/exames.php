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

    // VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
    $error = "";
    $sucess = "";
    if(count($_POST) > 0){
        $codigo = $_POST['codigo'];
        $descricao = $_POST['descricao'];

        if(empty($_POST['descricao'])){
            $error = "Campo descrição obrigatório*";
        }  
        if(empty($_POST['codigo']) || Strlen($codigo) > 3){
            $error = "Campo código deve conter 3 dígitos";
        }
        if($error){

        }
        // VERIFICAÇÃO SE O POST EMAIL EXISTE NO BANCO DE DADOS
        else{
            $sql_codeverify = "SELECT * FROM exames WHERE codigo = '$codigo'";
            $query_c = $mysqli->query($sql_codeverify);
            $verify = $query_c->fetch_assoc();

                if($verify){
                    $error = "Código exame já cadastrado!";
                }
            // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR
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
<link rel="stylesheet" href="../Arquivos CSS/usuarios.css">
<link rel="stylesheet" href="../Arquivos CSS/normalize.css">
<body> 
    <div class="full">
        <div class="From_Cadastrados">
            <a href="index.php">Retornar para pagina inicial</a>
            <h1>Tabela de exames</h1>
            <p>Esses são os exames cadastrados no seu sistema</p>
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
                        while($exames = $query_exames->fetch_assoc()){
                    ?>     
                    <tr>
                        <td><?php echo $exames['exameid']?>     </td>
                        <td><?php echo $exames['codigo']?>   </td>
                        <td><?php echo $exames['descricao']?>  </td>   
                        <td><a href="deletar_exame.php?id=<?php echo $exames['exameid'] ?>">Deletar exame</a></td>
 
                    </tr>             
                <?php
                    }
                    }
                ?>
                </tbody>
            </table>
        </div><br>
        <button onclick="lcadastro()">Cadastrar exames</button><br>
        <div class="insert_cadastrar" id="cadastrar_usuarios">
            <a onclick="fcadastro()">X</a><br><br>
            <form action="" method="POST">
                <label>Código exame</label>
                <input class="input_edit" type="text" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" name="codigo"><br><br>

                <label>Descrição exame</label>
                <input class="input_edit" type="text" value="<?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?>" name="descricao"><br><br>


                <button type="submit" name="cadastrar">Cadastrar exame</button>
            </form>

        </div>
        <?php 
                if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
                if($error){echo '<p class="error">'. $error . '</p>' ;}   
            ?>
    </div>    
    <script src="../Arquivos JS/usuarios.js"></script>
    <script src="../Arquivos JS/index.js"></script>
</body>
</html>
