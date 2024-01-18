<?php 
// SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}

function formatar_data($data){
    return implode('/', array_reverse(explode('-', $data)));
};

function formatar_telefone($telefone){
    $ddd = substr ($telefone, 0, 2);
    $parte1 = substr ($telefone, 2, 5);
    $parte2 = substr ($telefone, 7);
        return "($ddd) $parte1-$parte2";
}

function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}
?>

<?php
$id = intval($_GET['id']);
include('conexao.php');

$error = "";
// CAMPOS POST DO INSERT APÓS DAR O INPUT
if(count($_POST) > 0){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $unidade = $_POST['unidade'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
// VERICAÇÃO SE O INPUT NOME ESTÁ VAZIO OU ENTRE 3 Á 100 DÍGITOS 
    if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100){
        $error = "Por favor, Prencha o campo nome corretamente. Capacidade mínima 3 dígitos! ";
    }
// VERIFICAÇÃO SE O INPUT E-MAIL ESTÁ VAZIO OU NO PADRÃO DE VALIDADE EMAIL
    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Por favor, Prencha o campo e-mail corretamente.";
    }   
// VERIFICAÇÃO SE O INPUT NASCIMENTO ESTÁ OU DIFERENTE DE 10 DÍGITOS
    if(empty($nascimento) || strlen($nascimento) != 10){
        $error = "Campo nascimento deve ser preenchido no padrão dia/mês/ano";
    }
    // SE NÃO TIVER VAZIO, VAI UTILIZAR FUNÇÃO PADRÃO PHP PARA EXPLODIR AONDE ESTIVER / 
        else{
            $pedacos = explode('/', $nascimento);
    // VERIFICANDO SE APÓS EXPLODIR ESTÁ EM 3 PARTES EX: DIA MÊS ANO, PARA ENTÃO JUNTAR E REVERTER, SEGUINDO PADRÃO EUA
            if(count($pedacos) == 3){
                $nascimento = implode ('-', array_reverse($pedacos)); 
            }
    }    
    // VERIFICANDO SE INPUT TELEFONE ESTÁ VAZIO
    if(empty($telefone)){
        $error ="Campo telefone obrigatório";
    }
    // CASO NÃO TIVER, VAI TIRAR AS CARACTERES DO INPUT UTILIZANDO A FUNÇÃO RETIRADA DO SITE ZEROBUGS.COM. SE FICAR DIFERENTE DE 11 DÍGITOS[11995910318] -> VAI APARECER MENSAGEM DE ERRO 
        else{
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11){
                $error = "O telefone deve ser preenchido no padrão (11) 98888-8888";
            }
    }
// VERIFICANDO SE TEM ALGUM ERRO
    if($error){
    }
    // CASO NÃO TIVER NENHUM ERRO NAS VERIFICAÇÕES DE ERRO DOS CAMPOS, VAI ATUALIZAR AS INFORMAÇÕES DO USUÁRIO. CASO NÃO TIVER ALTERADO, SERÁ ATUALIZADO DO MESMO JEITO COM AS MESMAS INFORMAÇÕES INSERIDAS ATRÁVES DO SELECT FROM A BAIXO.
    else{
        $sql_code = "UPDATE clientes
        SET nome   = '$nome', 
        email      = '$email',
        unidade    = '$unidade',
        telefone   = '$telefone',
        nascimento = '$nascimento' WHERE id   = '$id'";
        
        $deu_certo = $mysqli->query($sql_code);
            if($deu_certo){
                $sucess ="Atualizado com sucesso";
                unset($_POST);
            }     
    }         
    }
// }
// SELECT FROM NA TABELA CLIENTES, PARA PUXAR INFORMAÇÕES DOS PACIENTES PARA OS CAMPOS INPUT
include('conexao.php');
$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);
$cliente = $query_cliente->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="usuarios.php">Retornar listagem de úsuarios</a>
    <form action="" method="POST">
        <p>
            <label>Nome:</label>
            <input value= "<?php echo $cliente['nome']; ?>" type="text" name="nome">
        </p>
        <p>
            <label>E-mail:</label>
            <input value ="<?php echo $cliente['email']; ?>" type="email" name="email">
        </p>
        <label>Unidade:</label>
            <input value ="<?php echo $cliente['unidade']; ?>" type="text" name="unidade">
        </p>
        <p>
            <label>Telefone:</label>
            <input value ="<?php if(!empty($cliente['telefone'])){ echo formatar_telefone($cliente['telefone']);} ?>" placeholder="(11) 98888-8888" type="text" name="telefone">
        </p>
        <p>
            <label>Data de nascimento:</label>
            <input value ="<?php if(!empty($cliente['nascimento'])){ echo formatar_data($cliente['nascimento']);} ?>" placeholder="dia/mês/ano" type="text" name="nascimento">
        </p>
        <p>
            <button type="submit">Enviar</button>
        </p>
<?php 
if(isset($error)){ echo $error;} 
if(isset($sucess)){ echo $sucess;}
?>
    </form>
</body>
</html>

