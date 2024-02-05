<?php 
// VERIFICAÇÃO DE SESSÃO
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../Control/function.php');
include('../Control/SelectFrom.php');
include('conexao.php');
$id = intval($_GET['id']);
$alert = "";
$sucess = "";

if(count($_POST) > 0){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];
    $codigo = $_POST['id_exame'];
    $CRM = $_POST['CRM'];
    $convenio = $_POST['convenio'];
    $diagnostico = $_POST['diagnostico'];
    $medicamentos = $_POST['medicamentos'];
    $observacoes = $_POST['observacoes'];
    $RG = $_POST['RG'];
    $CPF = $_POST['CPF'];
    $mae = $_POST['mae'];
    $CEP = $_POST['CEP'];
    $cidade = $_POST['cidade'];

    if(empty($CRM)){
        $alert = "CAMPO CRM OBRIGATÓRIO ";
    }else{
        $verify_crm = $mysqli->query("SELECT * FROM medicos WHERE CRM = '$CRM'");
        $verifycrm = $verify_crm->fetch_assoc();
        if($verifycrm){
            $CRM;
        }else{
            $alert = "CRM DO MÉDICO NÃO CADASTRADO";
        } 
    }

    if(empty($convenio)){
        $alert = "CAMPO CONVENIO OBRIGATÓRIO ";
    }else{
        $verify_convenio = $mysqli->query("SELECT * FROM convenio WHERE nome = '$convenio'");
        $verifyc = $verify_convenio->fetch_assoc();
        if($verifyc){
            $convenio;
        }else{
            $alert = "CONVÊNIO NÃO CADASTRADO";
        }
    }
    
    if(empty($RG))
        $alert = "CAMPO RG OBRIGATÓRIO ";

    if(empty($CPF))
        $alert = "CAMPO RG OBRIGATÓRIO ";

    if(empty($CEP))
        $alert = "CAMPO CEP OBRIGATÓRIO ";

    if(empty($cidade))
        $alert = "CAMPO CIDADE OBRIGATÓRIO ";

    if(empty($nome))
        $alert = "CAMPO NOME OBRIGATÓRIO ";

    if(Strlen($nome) < 3 || Strlen($nome) > 100)
        $alert = "NOME INCORRETO";

    if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $alert = "CAMPO E-MAIL INCORRETO";

    if(empty($nascimento))
        $alert = "DATA DE NASCIMENTO OBRIGATÓRIO";

    if(strlen($nascimento) != 10)
        $alert = "DATA DE NASCIMENTO INCORRETA";

    if(empty($telefone))
        $alert = "TELEFONE OBRIGATÓRIO";

    if(strlen($telefone) != 11)
        $alert = "TELEFONE INCORRETO";
    
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
                            $alert = "EXAME JÁ INSERIDO";
                            }
                            else{
                                $ql_insert = "INSERT INTO pacientes_exames (paciente_id, exame_id) VALUES ('$id', '$codigo')";
                                $query_insert = $mysqli->query($ql_insert);
                            }
                        }else{
                            $alert = "EXAME INEXISTENTE";
                        }
                    }
                    
    // VERIFICAÇÃO SE EXISTE ALGUM ERRO    
    if($alert){
        die($alert);
    }
    // ATUALIZAÇÃO DAS INFORMAÇÕES ALTERADAS
    else{
        $sql_code = "UPDATE pacientes
        SET nome = '$nome', 
        endereco = '$endereco',
        RG = '$RG',
        CEP = '$CEP',
        CPF = '$CPF',
        nome_mae = '$mae',
        cidade = '$cidade',
        CRM = '$CRM',
        Convenio = '$convenio',
        diagnostico = '$diagnostico',
        medicamentos = '$medicamentos',
        observacoes = '$observacoes',
        email      = '$email',
        telefone   = '$telefone',
        nascimento = '$nascimento' WHERE id  = '$id'";
        $deu_certo = $mysqli->query($sql_code);
            if($deu_certo){
                $alert = "ATUALIZADO COM SUCESSO";
                unset($_POST);
            }
    }
}

// VISUALIZAÇÃO INFORMAÇÕES USUÁRIO NO CAMPO EDIÇÃO
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
<link rel="stylesheet" href="../css/index.css">    
<link rel="stylesheet" href="../css/button.css">
<body>
    <div class="body-header">
        <div class="seletc_g">
            <div class="select_header">
                <div>
                    <a href="../views/index.php"><img class="icon_select" src="../icons/monitor (2).png">
                </div>
            </div>
            <div class="select_header">
                <div>
                    <a href="listagem_usuarios.php"><img  class="icon_select" src="../icons/monitor (2).png"></a>
                </div>
                <div>
                    <h3>
                        Usuários
                    </h3>
                </div>
            </div>
            <div class="select_header">
                <div>
                    <a href="../views/listagem_pacientes.php"><img class="icon_select" src="../icons/arquivo (1).png"></a>
                </div>
                <div>
                    <h3>
                        Pacientes
                    </h3>
                </div>
            </div>
            <div class="select_header">
                <div>
                    <a href="listagem_exames.php"><img class="icon_select" src="../icons/grafico.png"></a>
                </div>
                <div>
                    <h3>
                        Exames
                    </h3>      
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/moeda-de-dolar.png">
                </div>
                <div>
                    <h3>
                        Financeiro
                    </h3>        
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img class="icon_select" src="../icons/bate-papo.png">
                </div>
                <div>
                    <h3>
                        Suporte
                    </h3>           
                </div>
            </div>
            <div class="select_header">
                <div>
                    <img onclick="abrir_modal()" class="icon_select" src="../icons/calendario.png">
                </div>
                <div>
                    <h3>
                        Sugestões
                    </h3>
                </div>       
            </div>
            <div class="select_header">
                <div>
                <a href="../Control/logout.php"><img class="icon_select" src="../icons/fracassado.png"></a>
                </div>
                <div>
                    <h3>
                        Encerrar
                    </h3>
                </div>
            </div>
        </div>
    </div>

    <!-- !-- DIVISÃO Á BAIXO DO HEADER, PARA INFOS & AVISOS  -->
    <div class="Bottom_header">
        <p class="white">Usuário: <b><?php echo $usuario['nome']?></b></p>
        <p>Local System <b><?php echo $usuario['unidade']?></b></p>
    </div>

    <!-- INSERÇÃO CAMPOS POST NO FORM -->
    <div class="container_body">
        <div class="container_son">   
            <p>Informações do paciente:</p><br>
            <form action="" method="POST">
                <div>
                    <label>Nome: </label>
                    <input value="<?php echo $cliente['nome']; ?>" type="text" name="nome">

                    <label>RG: </label>
                    <input value="<?php echo $cliente['RG']; ?>" placeholder="RG do paciente" type="text" name="RG">

                    <label>CPF: </label>
                    <input value="<?php echo $cliente['CPF']; ?>" placeholder="CPF do paciente" type="text" name="CPF">

                    <label>Nome da mãe: </label>
                    <input value="<?php echo $cliente['nome_mae']; ?>" type="text" name="mae">

                    <label>Endereço:</label>
                    <input value= "<?php echo $cliente['endereco']; ?>" type="text" name="endereco"><br><br>
                    
                    <label>Cidade:</label>
                    <input value ="<?php if(!empty($cliente['cidade'])){ echo $cliente['cidade'];} ?>"  type="text" name="cidade">

                    <label>CEP:</label>
                    <input value ="<?php if(!empty($cliente['CEP'])){ echo $cliente['CEP'];} ?>" type="text" name="CEP">

                    <label>E-mail:</label>
                    <input value ="<?php if(!empty($cliente['telefone'])){ echo ($cliente['email']);} ?>" type="email" name="email">

                    <label>Telefone:</label>
                    <input value ="<?php if(!empty($cliente['telefone'])){ echo $cliente['telefone'];} ?>" placeholder="11988888888" type="text" name="telefone">

                    <label>Data de nascimento:</label>
                    <input value ="<?php if(!empty($cliente['nascimento'])){ echo $cliente['nascimento'];} ?>" placeholder="dia/mês/ano" type="date" name="nascimento"><br><br>
                   
                    <label>CRM: </label>
                    <input value="<?php echo $cliente['CRM']; ?>" placeholder="CRM do médico" ="text" name="CRM">

                    <label>Convênio:</label>
                    <input value ="<?php if(!empty($cliente['Convenio'])){ echo $cliente['Convenio'];} ?>" placeholder="Convênio do paciente?" type="text" name="convenio">

                    <label>Diagnóstico: </label>
                    <input value="<?php echo $cliente['diagnostico']; ?>" placeholder="diagnóstico" type="text" name="diagnostico">

                    <label>Medicamentos:</label>
                    <input value ="<?php if(!empty($cliente['medicamentos'])){ echo $cliente['medicamentos'];} ?>" placeholder="Medicamentos prescritos?" type="text" name="medicamentos">

                    <label>Observações:</label>
                    <input value ="<?php if(!empty($cliente['telefone'])){ echo $cliente['observacoes'];} ?>" placeholder="Alguma observação?" type="text" name="observacoes"><br><br>


                
                    <p>Adicionar um exame no atendimento:</p>
                    <label>Exame ID</label>
                    <input  type="text" name="id_exame"><br><br>
                    <button class="btn_style"type="submit">Enviar</button><br><br>
                </p>
            </form>
            <?php
                if(isset($alert)) echo $alert;
            ?>
        </div>
        <div class="container_son">   
            <!-- TABELA DE INFORMAÇÕES EXAMES CADASTRADOS DO PACIENTE -->
            <table border="1px"cellpadding="10">
                <thead>
                    <th>ID Exames</th>
                    <th>código exame</th>
                    <th>Nome exame</th>
                    <th>Resultado</th>
                    <th>Inserir Resultado</th>
                    <th>Remover</th>

                </thead>
                <tbody> <?php if($num_exames == 0) {?>
                    <tr>
                        <td colspan="7">Nenhum exame foi encontrado!</td>
                    </tr> <?php } ?>
                <?php while($exames = $query_exames->fetch_assoc()){?>
                        
                    <tr>
                        <td><?php echo $exames['exame_id']?></td>
                        <td><?php echo $exames['codigo']?></td>
                        <td><?php echo $exames['descricao']?></td>
                        
                        <td><?php if($exames['resultado'] == 0){ }else echo number_format($exames['resultado'], 1, ',', '.')?></td>
                        <td><a href="inserir_resultado.php?id=<?php echo $exames['id']?>">inserir</a></td>
                        <td><a href="../Control/remover_exame_paciente.php?id=<?php echo $exames['id']?>">X</a></td>
                    </tr><?php }?> 
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

