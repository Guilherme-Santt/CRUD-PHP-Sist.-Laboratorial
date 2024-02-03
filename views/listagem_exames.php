<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('conexao.php');
include('../Control/SelectFrom.php');
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exames</title>
</head>
<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../css/index.css">
<link rel="stylesheet" href="../css/modal.css">
<link rel="stylesheet" href="../css/button.css">

<body> 
    <!-- HEADER SUPERIOR -->
    <div class="body-header">
        <div class="seletc_g">
            <div class="select_header">
                <div>
                    <a href="index.php"><img class="icon_select" src="../icons/monitor (2).png"></a>
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
                    <a href=""><img class="icon_select" src="../icons/grafico.png"></a>
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
        <p class="white">Usuário: <b><?php echo $usuario['nome']?></b></p>
        <p>Local System <b><?php echo $usuario['unidade']?></b></p>
    </div>

    <!-- DIV PARA TABELA COM INFORMAÇÕES DOS EXAMES -->
    <div class="container_body">
        <div class="container_son">
            <div>
                <button class="btn_style" onclick="abrir_modal()">Cadastrar exames</button>
            </div>
            
            <p>Exames cadastrados em seu sistema</p>
            <table border="1px">
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
                            while($exames = $query_exames->fetch_assoc()){?>     
                        <tr>
                            <td><?php echo $exames['exameid']?>     </td>
                            <td><?php echo $exames['codigo']?>   </td>
                            <td><?php echo $exames['descricao']?>  </td>   
                            <td><a href="../Control/deletar_exame.php?id=<?php echo $exames['exameid'] ?>">Deletar exame</a></td>
                        </tr>      
                    <?php     }
                        } ?>
                </tbody>
            </table><br>
        </div>
    </div>

    <!-- JANELA MODAL->CADASTRO DE EXAMES NO SISTEMA -->
    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button><br>
            <form action="../Control/Post_CriarExames.php" method="POST">
                <p>Cadastrar exame⤵</p>
                <label>Código exame</label><br><br>
                <input type="text" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>" name="codigo"><br><br>
    
                <label>Descrição exame</label></label><br><br>
                <input type="text" value="<?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?>" name="descricao"><br><br>
    
                <button class="btn_style" type="submit" name="cadastrar">Cadastrar exame</button>
            </form>
        </div>
    </div>    
<script src="../src/script.js"></script>
</body>
</html>
