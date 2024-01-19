<?php 
// VERIFICAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
// FUNÇÃO VISUALIZAÇÕES DE CAMPO DATA E SENHA PADRÃO BR
function formatar_data($data){
    return implode('/', array_reverse(explode('-', $data)));
}

// FUNÇÃO FORMATAR TELEFONE PARA VISUALIZAÇÃO COM CARACTERES
function formatar_telefone($telefone){
    $ddd = substr ($telefone, 0, 2);
    $parte1 = substr ($telefone, 2, 5);
    $parte2 = substr ($telefone, 7);
        return "($ddd) $parte1-$parte2";
}
// FUNÇÃO LIMPAR CARACTERES 
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}
    
$id = intval($_GET['id']);
include('conexao.php');
$error = "";
$sucess = "";

if(count($_POST) > 0){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $codigo = $_POST['id_exame'];

    if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100){
        $error = "Por favor, Prencha o campo nome corretamente. Capacidade mínima 3 dígitos! ";
    }

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Por favor, Prencha o campo e-mail corretamente.";
    }   

    if(empty($nascimento) || strlen($nascimento) != 10){
        $error = "A data de nascimento deve ser preenchido no padrão dia/mes/ano*";
    }
    else{
        $pedacos = explode('/', $nascimento);
        if(count($pedacos) == 3){
        $nascimento = implode ('-', array_reverse($pedacos)); 
        } 
    }   

    if(empty($telefone)){
        $error = "campo telefone obrigatório*";}
        else{
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11){
                $error = "O telefone deve ser preenchido no padrão (11) 98888-8888";
        }   
    }
    // INSERÇÃO CAMPO EXAME NA TABELA PACIENTES_EXAMES
    if(!empty($codigo)){
        // VERIFICAÇÃO SE O EXAME EXISTE NA TABELA EXAMES
        $sql_verify = "SELECT * FROM exames WHERE exameid = '$codigo'";
        $query_verify = $mysqli->query($sql_verify);
        $verify_existencia_exame = $query_verify->fetch_assoc();

        if($verify_existencia_exame){
                $sql_verify = "SELECT * FROM pacientes_exames WHERE exame_id = '$codigo' AND paciente_id = '$id' ";
                $query_verify = $mysqli->query($sql_verify);
                $verify_cadastro_exame_no_paciente = $query_verify->fetch_assoc();
                        if($verify_cadastro_exame_no_paciente){
                            $error = "Exame já inserido*";
                            }
                            else{
                                $ql_insert = "INSERT INTO pacientes_exames (paciente_id, exame_id) VALUES ('$id', '$codigo')";
                                $query_insert = $mysqli->query($ql_insert);
                            }
            }else{
                $error = "Exame não existe";
            }
    }
    // VERIFICAÇÃO SE EXISTE ALGUM ERRO    
    if($error){
    }
    // ATUALIZAÇÃO DAS INFORMAÇÕES ALTERADAS
    else{
        $sql_code = "UPDATE pacientes
        SET nome = '$nome', 
        sexo = '$sexo',
        endereco = '$endereco',
        email      = '$email',
        telefone   = '$telefone',
        nascimento = '$nascimento' WHERE id  = '$id'";
        $deu_certo = $mysqli->query($sql_code);
            if($deu_certo){
                $sucess = "Atualizado com Sucesso!";
                unset($_POST);
            }
    }
    
}
// VISUALIZAÇÃO INFORMAÇÕES USUÁRIO NO CAMPO EDIÇÃO
include('conexao.php');
$sql_cliente = "SELECT * FROM pacientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

// CAMPOS EXAMES DO PACIENTE / ID DO EXAME / ID DO PACIENTE
$sql_exame = "SELECT * FROM pacientes_exames AS pacex
    INNER JOIN exames ON exames.exameid = pacex.exame_id WHERE pacex.paciente_id = '$id'";

$query_exames = $mysqli->query($sql_exame);
$num_exames = $query_exames->num_rows;

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informações do paciente</title>
</head>
<link rel="stylesheet" href="../Arquivos CSS/button.css">
<link rel="stylesheet" href="../Arquivos CSS/tabela.css">
<link rel="stylesheet" href="../Arquivos CSS/efeito_a.css">
<link rel="stylesheet" href="../Arquivos CSS/input.css">

<body>
    <!-- INSERÇÃO CAMPOS POST NO FORM -->
    <button><a href="index.php">Pagina inicial</button> </a> <br><br>

    <form action="" method="POST">
            <label>Nome: </label>
            <input class="input_edit" value="<?php echo $cliente['nome']; ?>" type="text" name="nome">
 
            <label>Endereço:</label>
            <input class="input_edit" value= "<?php echo $cliente['endereco']; ?>" type="text" name="endereco">

            <label>Sexo:</label>
            <input class="input_edit" value= "<?php if($cliente['sexo']) echo $cliente['sexo']; ?>" type="text" name="sexo">

            <label>E-mail:</label>
            <input class="input_edit" value ="<?php if(!empty($cliente['telefone'])){ echo ($cliente['email']);} ?>" type="email" name="email">

            <label>Telefone:</label>
            <input class="input_edit" value ="<?php if(!empty($cliente['telefone'])){ echo formatar_telefone($cliente['telefone']);} ?>" placeholder="(11) 98888-8888" type="text" name="telefone">

            <label>Data de nascimento:</label>
            <input class="input_edit" value ="<?php if(!empty($cliente['nascimento'])){ echo formatar_data($cliente['nascimento']);} ?>" placeholder="dia/mês/ano" type="text" name="nascimento">
        <p>
            <label>Exame ID</label>
            <input class="input_edit" type="text" name="id_exame">
            <button class="button_slide" type="submit">Enviar</button>
        </p>
    </form>
    <?php
            if(isset($error)) echo $error;
            if(isset($sucess)) echo $sucess;
            ?>
    <!-- TABELA DE INFORMAÇÕES EXAMES CADASTRADOS DO PACIENTE -->
    <table border="1" cellpadding="10">
        <thead>
            <th>ID Exames</th>
            <th>código exame</th>
            <th>Nome exame</th>
        </thead>
        <tbody> <?php if($num_exames == 0) {?>
            <tr>
                <td colspan="7">Nenhum exame foi encontrado!</td>
            </tr> <?php } ?>
            <h1>Exames cadastrados</h1>
        <?php while($exames = $query_exames->fetch_assoc()){?>
            <tr>
                <td><?php echo $exames['exame_id']?></td>
                <td><?php echo $exames['codigo']?></td>
                <td><?php echo $exames['descricao']?></td>
                <td><a href="remover_exame.php?id=<?php echo $exames['id']?>"><button>x</button></a></td>
            </tr><?php }?> 
        </tbody>
    </table>
</body>
</html>

