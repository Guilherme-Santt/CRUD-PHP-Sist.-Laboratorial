<?php 
include('conexao.php');
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../Control/SelectFrom.php');     
include('../Control/function.php');
$sql_pacientes   = "SELECT * FROM pacientes";
$query_pacientes = $mysqli->query($sql_pacientes) or die($mysqli->error);
$num_pacientes = $query_pacientes->num_rows; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes</title>
</head>

<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../css/modal.css">
<link rel="stylesheet" href="../css/index.css">
<link rel="stylesheet" href="../css/button.css"
<body>
 <!-- HEADER SUPERIOR -->
    <div class="body-header">
        <div class="seletc_g">
            <div class="select_header">
                <div>
                    <a href="../views/index.php"><img class="icon_select" src="../icons/monitor (2).png"></a>
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

    <!-- DIVISÃO Á BAIXO DO HEADER, PARA INFOS & AVISOS -->
    <div class="Bottom_header">

    </div>

    <!-- TABELA DE PACIENTES CADASTRADOS -->
    <div class="container_body">
        <div class="container_son">       
            <div>
                <button class="btn_style" onclick="abrir_modal()">Cadastro rápido</button>       
                <a href="Criar_Paciente.php"><button class="btn_style">Cadastro Completo</button></a>

            </div><br>
            <p>Seus pacientes cadastrados</p>
            <table cellpadding="10">
                <thead>
                    <th>Atendimento</th>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Sexo</th>
                    <th>E-mail</th>
                    <th>Celular</th>
                    <th>Nascimento</th>
                    <th>Convênio</th>
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
                                <td><?php if(!empty($pacientes['Convenio'])){echo $pacientes['Convenio'];}else{ echo "Convênio não informado";}?>  </td>
                                <td><?php echo $data_cadastro;?>    </td>
                                <td>
                                <a class="edit" href="editar_paciente.php?id=<?php echo $pacientes['ID']?>">Editar</a>
                                <a class="error" href="../Control/deletar_paciente.php?id=<?php echo $pacientes['ID']?>">Deletar</a>
                            </td>
                            </tr>
                            <?php
                        }
                    } 
                    ?>
                </tbody>
            </table>
            <p>Caso for realizado o cadastro através da opção "Cadastro rápido" será necessário completar as informações do paciente posteriormente para ter êxito ao conferi-lo.</p>
        </div>
    </div>
    
    
    <!-- TELA MODAL->CADASTRO DE PACIENTES -->
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <!-- FORMULARIO POST INFORMAÇÕES DE CADASTRO -->
            <form action="../Control/Post_CriarPacientesRapido.php" method="POST">
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
                <input  value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="11988888888" type="text" name="telefone"><br><br>
                    
                <input type="radio" value="Feminino" name="sexo">Feminino<br>
                <input type="radio" value="Masculino" name="sexo">Masculino<br><br>

                <button type="submit" name="cadastrar">Cadastrar</button>
            </form>
        </div>
    </div>
    <script src="../src/modal.js"></script>
</body>
</html>

