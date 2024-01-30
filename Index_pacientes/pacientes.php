<?php 
// VERICIAÇÃO DE SESSÃO
include('../conexao/conexao.php');
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }  
}      
   
// VERIFICAÇÃO DA INSERÇÃO DOS CAMPOS POST NO FORM
$error = "";
if(count($_POST) > 0){
    $email = $_POST['email']; 
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    if(!empty($_POST['sexo'])){
        $sexo = $_POST['sexo'];
    }else{ } 
    
    if(empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $error = "CAMPO E-MAIL OBRIGATÓRIO";

    if(empty($_POST['endereco']))
        $error = "CAMPO ENDEREÇO OBRIGATÓRIO";

    if(empty($_POST['sexo']) )
        $error = "SELEÇÃO SEXO OBRIGATÓRIA";

    if(empty($_POST['nome']) || Strlen($nome) < 3 || Strlen($nome) > 100)
        $error = "CAMPO NOME OBRIGATÓRIO";

    if(empty($nascimento) || strlen($nascimento) < 10 || strlen($nascimento) > 10 )
        $error = "DATA DE NASCIMENTO DEVE SEGUIR PADRÃO DIA/MÊS/ANO";     

    if(empty($telefone)){
        $error ="CAMPO TELEFONE OBRIGATÓRIO";
        }
        else{
            $telefone = limpar_texto($telefone);
            if(strlen($telefone) != 11){
                $error = "TELEFONE DEVE SEGUIR O PADRÃO (11) 98888-8888";
            }
        }
    if($error){}
        else{
            $sql_codeverify = "SELECT * FROM pacientes WHERE email = '$email'";
            $query_c = $mysqli->query($sql_codeverify);
            $paciente = $query_c->fetch_assoc();
            $verify = $query_c->num_rows;
                if($verify){
                    $error = "PACIENTE JÁ CADASTRADO";
                    }
                    else{
                        $sqlinsert = "INSERT INTO pacientes (nome, email, endereco, telefone, nascimento, data, sexo)  
                        values ('$nome', '$email', '$endereco', '$telefone', '$nascimento', NOW(), '$sexo')";
                        $queryinsert = $mysqli->query($sqlinsert);
                            if($queryinsert){
                                $sucess = "PACIENTE CADASTRADO COM SUCESSO";
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
    <title>Pacientes</title>
</head>
<style>
body{
  width: 100%;
  height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../Arquivos CSS/modal.css">

<body>       
    <!-- TELA MODAL->CADASTRO DE PACIENTES -->
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <!-- FORMULARIO POST INFORMAÇÕES DE CADASTRO -->
            <form action="" method="POST">
                <p>Cadastrar paciente⤵</p>
                <label>Nome</label><br>
                <input  type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome"><br><br>

                <label>E-mail</label><br>
                <input  type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email"><br><br>

                <label>Endereço</label><br>
                <input  type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>" name="endereco"><br><br>


                <label>Nascimento</label><br>
                <input  type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano"><br><br>
                    
                <label>Telefone:</label><br>
                <input  value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(11) 98888-8888" type="text" name="telefone"><br><br>
                    
                <input type="radio" value="Feminino" name="sexo">Feminino<br>
                <input type="radio" value="Masculino" name="sexo">Masculino<br><br>

                <button type="submit" name="cadastrar">Cadastrar</button>
            </form>
        </div>
    </div>
    
<?php  
// FUNÇÃO FORMATAR DATA PADRÃO BRASILEIRO VISUALIZAÇÃO 
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
// FUNÇÃO LIMPA TEXTO AO INSERIR TELEFONE 
function limpar_texto($str){ 
    return preg_replace("/[^0-9]/", "", $str); 
}
// COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
$sql_pacientes   = "SELECT * FROM pacientes";
$query_pacientes = $mysqli->query($sql_pacientes) or die($mysqli->error);
$num_pacientes = $query_pacientes->num_rows; 
?>
    <!-- TABELA DE PACIENTES CADASTRADOS -->
    <div class="janela_tabela">       
        <div>
            <a href="../SystemLocal/index.php"><button class="button1">Pagina inicial</button> </a>
            <button class="button1" onclick="abrir_modal()">Cadastrar paciente</button>
        </div>
        <h1>Atendimentos</h1>
        <table border="1" cellpadding="10">
            <thead>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Sexo</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Nascimento</th>
                <th>Data de cadastro</th>
                <th>Ações</th>
            </thead>
            <tbody>        
        <?php if($num_pacientes == 0) { ?> 
                <tr>
                    <td colspan="7">Nenhum paciente foi encontrado!</td>
                </tr><?php }
                else{ 
                    while($pacientes = $query_pacientes->fetch_assoc()){

                        $telefone ="Não informado!";
                        // SE O CAMPO CONSULTADO NÃO TIVER VÁZIO, UTILIZARÁ FUNÇÃO PARA FORMATAR O MESMO COM CARACTERES
                        if(!empty($pacientes['telefone'])){
                            $telefone = formatar_telefone($pacientes['telefone']);   
                        }

                        $nascimento = "Nascimento não informada!";
                        // SE O CAMPO CONSULTADO NÃO TIVER VÁZIO, UTILIZARÁ FUNÇÃO QUE PEGA O CAMPO SQL ANO-MES-DIA ALTERANDO - POR / E REVERTER OS CAMPOS PARA DIA/MES/ANO 
                        if(!empty($pacientes['nascimento'])){
                            $nascimento = formatar_data($pacientes['nascimento']);
                        }
                        // FUNÇÃO DATE (PADRÃO DO PHP) PARA CONVERTER DATA DE CADASTRO NO SQL PARA DIA/MES/ANO E HORA
                        $data_cadastro = date("d/m/y H:i:s", strtotime($pacientes['data']));?>     
                        <tr>
                            <td><?php echo $pacientes['ID']?>     </td>
                            <td><?php echo $pacientes['nome']?>   </td>
                            <td><?php echo $pacientes['endereco']?>   </td>
                            <td><?php echo $pacientes['sexo']?>   </td>
                            <td><?php echo $pacientes['email']?>  </td>
                            <td><?php echo $telefone; ?>  </td>
                            <td><?php echo $nascimento ?>   </td>
                            <td><?php echo $data_cadastro;?>    </td>
                            <td>
                            <a class="edit" href="editar_paciente.php?id=<?php echo $pacientes['ID']?>">Editar</a>
                            <a class="error" href="deletar_paciente.php?id=<?php echo $pacientes['ID']?>">Deletar</a>
                            </td>
                        </tr>
                    <?php
                    }
                    } 
                    ?>
            </tbody>
        <?php 
        if(isset($sucess)){echo'<p class="sucess">'. $sucess . '</p>' ;}
        if($error){echo '<p class="error">'. $error . '</p>' ;} ?>
    </div>
<script src="../Arquivos JS/script.js"></script>
</body>
</html>

