<?php 
// SESSÃO
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
}
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
    
        if(empty($nome) || Strlen($nome) < 3 || Strlen($nome) > 100){
            $error = "Por favor, Prencha o campo nome corretamente. Capacidade mínima 3 dígitos! ";
        }

        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error = "Por favor, Prencha o campo e-mail corretamente.";
        }   

        if(empty($nascimento) || strlen($nascimento) != 9){
            $error = "Data de nascimento obrigatório*";}
            else{
                $pedacos = explode('/', $nascimento);
                if(count($pedacos) == 3){
                $nascimento = implode ('-', array_reverse($pedacos)); 
                }
                else{
                    $error = "A data de nascimento deve ser preenchido no padrão dia/mes/ano";
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

        if($error){
        }
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




    $sql_exame = "SELECT * FROM pacientes_exames WHERE paciente_id = '$id'";
    $query_exames = $mysqli->query($sql_exame);
    $num_exames = $query_exames->num_rows;



    $sql_cliente = "SELECT * FROM exames";
    $query_cliente = $mysqli->query($sql_cliente) or die ($mysqli->error);

    while($exameinfo = $query_cliente->fetch_assoc()){
        echo $exameinfo['nome'] . "<br>";
        echo $exameinfo['codigo'] . "<br>";
        echo $exameinfo['descricao']  . "<br>";
    }

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
    <a href="pacientes.php">Retornar listagem de pacientes</a>
    <form action="" method="POST">
        <p>
            <label>Nome: <?php echo $cliente['nome']; ?> </label>
            <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome">
        </p>
        <p>
            <label>Endereço:</label>
            <input value= "<?php echo $cliente['endereco']; ?>" type="text" name="endereco">
        </p>
        <p>
            <label>Sexo:</label>
            <input value= "<?php if($cliente['sexo']) echo $cliente['sexo']; ?>" type="text" name="sexo">
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
    <table border="1" cellpadding="10">
        <thead>
            <th>ID Exames</th>
            <th>código exame</th>
            <th>Nome exame</th>
            <th>descrição exame</th>
        </thead>
        <tbody> 
            <?php 
            if($num_exames == 0) {?>
                <tr>
                    <td colspan="7">Nenhum exame foi encontrado!</td>
                </tr>
            <?php } ?>
            <?php
            while($exames = $query_exames->fetch_assoc()){?>
                <tr>
                    <td><?php echo $exames['exame_id']?></td>
                </tr> 
            <?php }?> 
        </tbody>
    </table>


        <?php
            if(isset($error)) echo $error;
            if(isset($sucess)) echo $sucess;

        ?>
</body>
</html>

