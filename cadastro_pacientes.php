<?php
    include('conexao.php');
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
    // SESSÃO TABELA USUARIO
    $id = $_SESSION['usuario'];
    $sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
    $query = $mysqli->query($sqlcode);
    $cliente = $query->fetch_assoc();
}
    function limpar_texto($str){ 
        return preg_replace("/[^0-9]/", "", $str); 
    }
?>

<?php
    // INFORMAÇÕES TABELA PACIENTES
    include('conexao.php');
    $id = $_SESSION['usuario'];
    $sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
    $query = $mysqli->query($sqlcode);
    $cliente = $query->fetch_assoc();

    function formatar_data($data){
        return implode('/', array_reverse(explode('-', $data)));
    };
    // FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
    function formatar_telefone($telefone){
        $ddd = substr ($telefone, 0, 2);
        $parte1 = substr ($telefone, 2, 5);
        $parte2 = substr ($telefone, 7);
        return "($ddd) $parte1-$parte2";
    }
    include('conexao.php');
    // COMANDO SQL PARA CONSULTAR CLIENTES
    $sql_clientes   = "SELECT * FROM clientes";
    // COMANDO QUERY, PARA EXECUTAR COMANDO SQL
    $query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
    // COMANDO NUM ROWS, PARA CONTAR QUANTIDADE DADOS NO BANCO
    $num_clientes   = $query_clientes->num_rows;
?>

<?php
    // INSERÇÃO POST TABELA PACIENTES
    $error = "";
    if(count($_POST) > 0){
        $email = $_POST['email'];
        $sexo = $_POST['sexo'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];

        if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Campo e-mail obrigatório*";
        }

        if(empty($_POST['endereco'])){
            $error = "Campo endereço obrigatório*";
        }
        if(!empty($_POST['sexo']) ){
            if(strlen($sexo) != 3){
                $error = "Escreva campo FEM ou MAS";
            }
        }    
        if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100){
            $error = "Campo nome obrigatório*";
        }
        if(!empty($nascimento)){
            $pedacos = explode('/', $nascimento);
            if(count($pedacos) == 3){
                $nascimento = implode ('-', array_reverse($pedacos)); 
            }
            else{
                $erro = "A data de nascimento deve ser preenchido no padrão dia/mes/ano";
            }
        }    
        if(!empty($telefone)){
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11){
                $erro = "O telefone deve ser preenchido no padrão (11) 98888-8888";
            }
        }
        if($error){

        }else{
            $sql_codeverify = "SELECT * FROM pacientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $paciente = $query_c->fetch_assoc();
            $verify = $query_c->num_rows;
                if($verify){
                    $error = "paciente já cadastrado!";
                }
                else{
                    $sqlinsert = "INSERT INTO pacientes (nome, email, endereco, telefone, nascimento, data, sexo)  
                    values ('$nome', '$email', '$endereco', '$telefone', '$nascimento', NOW(), '$sexo')";
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
<body>
</head>
<link rel="stylesheet" href="usuarios.css">
<link rel="stylesheet" href="normalize.css">
<body> 
<h1>Listagem de pacientes</h1>
            <p>Esses são os pacientes cadastrados no seu sistema</p>
            <table border="1" cellpadding="10">
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Sexo</th>
                    <th>exmes</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Data de cadastro</th>
                    <th>Ações</th>
                </thead>
                <tbody> 
                <?php 
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
                        <td><?php echo $paciente['id']?>     </td>
                        <td><?php echo $paciente['nome']?>   </td>
                        <td><?php echo $paciente['endereco']?>     </td>
                        <td><?php echo $paciente['sexo']?>     </td>
                        <td><?php echo $paciente['id_exame']?>     </td>
                        <td><?php echo $paciente['email']?>  </td>
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
            </table>

    <h1>Cadastrar Pacientes</h1>
        <form action="" method="POST">
            <label>Email</label>
            <input class="input_edit" type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>

            <label>Endereço</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>" name="endereco"><br><br>

            <label>Nome</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome"><br><br>

            <label>Nascimento</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano"><br><br>
                
            <label>Telefone:</label>
            <input class="input_edit" value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br><br>
                
            <label>sexo</label>
            <input class="input_edit" type="text" value="<?php if(isset($_POST['sexo'])) echo $_POST['sexo']; ?>"placeholder="MAS ou FEM" name="sexo"><br><br>

            <button type="submit" name="cadastrar">Cadastrar</button>
        </form>
        <?php 
            if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
            if($error){echo '<p class="error">'. $error . '</p>' ;}   
        ?>
        <script href="index.js"></script>
</body> 
</html>