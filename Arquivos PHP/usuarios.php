<?php
// // VERIFICAÇÃO SE O USUÁRIO ESTÁ LOGADO
//     if(!isset($_SESSION)){
//         session_start();
//         if(!isset($_SESSION['usuario'])){
//             die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
//         }    
// }
    // FUNÇÃO FORMATAR DATA PARA VISUALIZAÇÃO PADRÃO BR
    function formatar_data($data){
        return implode('/', array_reverse(explode('-', $data)));
    };
    // FUNÇÃO LIMPAR CARACTERES NO CAMPO TELEFONE
    function limpar_texto($str){ 
        return preg_replace("/[^0-9]/", "", $str); 
    }
    
    // FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
    function formatar_telefone($telefone){
        $ddd = substr ($telefone, 0, 2);
        $parte1 = substr ($telefone, 2, 5);
        $parte2 = substr ($telefone, 7);
        return "($ddd) $parte1-$parte2";
    }
    include('conexao.php');

?>

<?php

    // VERIFICAÇÃO DE INSERÇÃO NOS CAMPOS POST DO FORMULÁRIO
    $error = "";
    if(count($_POST) > 0){
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "preencha o campo email!";
        }
        if(empty($_POST['senha'])){
            $error = "preencha o campo senha!";
        }  
        if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100){
            $error = "preencha o campo nome!";
        }

        if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 ){
            $error = "A data de nascimento deve ser preenchido no padrão dia/mes/ano";
        }
        else{
        $pedacos = explode('/', $nascimento);
            if(count($pedacos) == 3){
                $nascimento = implode ('-', array_reverse($pedacos)); 
            }
        }    
        if(empty($telefone)){
            $error ="Campo telefone obrigatório";
        }else{
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11){
                $error = "O telefone deve ser preenchido no padrão (11) 98888-8888";
            }
        }
        
        if($error){
            
        }
        // VERIFICAÇÃO SE O POST EMAIL EXISTE NO BANCO DE DADOS
        else{
            $sql_codeverify = "SELECT * FROM clientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $usuario = $query_c->fetch_assoc();
                if($usuario){
                    $error = "usuário já cadastrado!";
                }
            // INSERÇÃO DAS INFORMAÇÕES NO BANCO, CASO NÃO EXISTIR
                else{
                    $sqlinsert = "INSERT INTO clientes (nome, email, telefone, nascimento, data, senha)  values ('$nome', '$email', '$telefone', '$nascimento', NOW(), '$senha')";
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
    <title>Listagem de usuários</title>
</head>
<!-- ARQUIVOS CSS SITE -->
<style>
body{
  width: 100%;
  height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
<link rel="stylesheet" href="../Arquivos CSS/input.css">
<link rel="stylesheet" href="../Arquivos CSS/janela_tabela.css">
<link rel="stylesheet" href="../Arquivos CSS/normalize.css">
<link rel="stylesheet" href="../Arquivos CSS/button.css">
<link rel="stylesheet" href="../Arquivos CSS/efeito_a.css">
<link rel="stylesheet" href="../Arquivos CSS/tabela.css">
<link rel="stylesheet" href="../Arquivos CSS/modal.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hedvig+Letters+Serif:opsz@12..24&family=Roboto+Condensed:ital,wght@1,200;1,300;1,400&display=swap" rel="stylesheet">

<!-- DIVISÃO MODAL -> CADASTRO DE USUARIOS -->
<body> 
    <!-- DIVISÃO TABELA DE USUARIOS CADASTRADOS -->
    <div class="janela_tabela">
        <div>
            <button><a href="index.php">Pagina inicial</button> </a>
            <button onclick="abrir_modal()">Cadastrar usuário</button>  
        </div> 
        <h1>Usuários</h1>
        <p>
            <?php 
            if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
            if($error){echo '<p class="error">'. $error . '</p>' ;}   
            ?>
        </p>    
        <table ID="alter" border="1" cellpadding="10">
            <thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Unidade</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Data de nascimento</th>
                <th>Data de cadastro</th>   
                <th>Ações</th>
            </thead>
            <tbody> 
                <?php 
                // COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
                $sql_clientes   = "SELECT * FROM clientes";
                $query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
                $num_clientes = $query_clientes->num_rows;
                if($num_clientes == 0) { 
                    ?> 
            <tr>
                <td colspan="7">Nenhum usuário foi encontrado!</td>
            </tr>
            <?php }
                else{ 
                    while($cliente = $query_clientes->fetch_assoc()){
                        $telefone ="Não informado!";
                        if(!empty($cliente['telefone'])){
                            $telefone = formatar_telefone($cliente['telefone']);   
                        }
                            $nascimento = "Nascimento não informada!";
                        if(!empty($cliente['nascimento'])){
                            $nascimento = formatar_data($cliente['nascimento']);
                        }
                        $data_cadastro = date("d/m/y H:i:s", strtotime($cliente['data']));
                ?>     
                <tr>
                    <td><?php echo $cliente['id']?>     </td>
                    <td><?php echo $cliente['nome']?>   </td>
                    <td><?php echo $cliente['unidade']?>     </td>
                    <td><?php echo $cliente['email']?>  </td>
                    <td><?php echo $telefone; ?>  </td>
                    <td><?php echo $nascimento ?>   </td>
                    <td><?php echo $data_cadastro;?>    </td>
                    <td>
                        <a class="edit" href="editar_usuario.php?id=<?php echo $cliente['id']?>">Editar</a>
                        <a class="error" href="deletar_usuario.php?id=<?php echo $cliente['id']?>">Deletar</a>
                    </td>
                </tr>             
                <?php
                }
            }
            ?>
            </tbody>
        </table><br>
    </div>
    
    <div class="janela-modal" id="janela-modal">

        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <form action="" method="POST">
                <label>Email</label><br>
                <input class="input_edit" type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>
        
                <label>Nome</label><br>
                <input class="input_edit" type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome"><br><br>
        
                <label>Nascimento</label><br>
                <input class="input_edit" type="text" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano"><br><br>
                
                <label>Telefone:</label><br>
                <input class="input_edit" value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br><br>
                
                <label>Senha</label><br>
                <input class="input_edit" type="password" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>" name="senha"><br><br>
                <button class="button_slide" type="submit" name="cadastrar">Enviar</button>
            </form>
        </div>
    </div>
    
    <script src="../Arquivos JS/script.js"></script>
</body>
</html>
