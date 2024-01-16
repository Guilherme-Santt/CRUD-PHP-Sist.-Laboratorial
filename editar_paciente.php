<?php 
// SESSÃO
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
}
$id = intval($_GET['id']);
include('conexao.php');
// FUNÇÃO VISUALIZAÇÕES DE CAMPO DATA E SENHA PADRÃO BR
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
    $erro = false;
    // VERIFICAÇÃO INSERÇÃO CAMPOS POST NO INPUT FORM
    if(count($_POST) > 0){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $nascimento = $_POST['nascimento'];
    
        if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100){
            $erro = "Por favor, Prencha o campo nome corretamente. Capacidade mínima 3 dígitos! ";
        }

        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erro = "Por favor, Prencha o campo e-mail corretamente.";
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

        if($erro){
            // echo "<p><b>$erro</b></p>";
        }

        // VERIFICAÇÃO SE EXISTE INPUT EMAIL NO BANCO DE DADOS
        else{
                $sql_code = "UPDATE clientes
                SET nome   = '$nome', 
                email      = '$email',
                telefone   = '$telefone',
                nascimento = '$nascimento' WHERE id   = '$id'";
                $deu_certo = $mysqli->query($sql_code);
                }
                    if(isset($deu_certo)){
                        $error = "Atualizado com Sucesso!";
                        unset($_POST);
                    }else{
                        $error = "Falha ao atualizar!";

                    }     
        }
    
    // VISUALIZAÇÃO INFORMAÇÕES USUÁRIO NO CAMPO EDIÇÃO
    include('conexao.php');
    $sql_cliente = "SELECT * FROM pacientes WHERE id = '$id'";
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
<style>
    /* body{
        background-color: black;
        color: white;
        border-color: white;
    } */
</style>
<body>
    <a href="usuarios.php">Retornar listagem de úsuarios</a>
    <form action="" method="POST">
        <p>
            <label>Nome:</label>
            <input value= "<?php echo $cliente['nome']; ?>" type="text" name="nome">
        </p>
        <p>
            <label>Endereço:</label>
            <input value= "<?php echo $cliente['endereco']; ?>" type="text" name="nome">
        </p>
        <p>
            <label>Sexo:</label>
            <input value= "<?php if($cliente['sexo']) echo $cliente['sexo']; ?>" type="text" name="nome">
        </p>
        <p>
            <label>E-mail:</label>
            <input value ="<?php echo $cliente['email']; ?>" type="email" name="email">
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
    </form>
            <?php 
            if(isset($error)) echo $error;
        ?>
</body>
</html>

