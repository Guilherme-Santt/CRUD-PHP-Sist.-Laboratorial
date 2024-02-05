<?php
include('conexao.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="../css/button.css">
<link rel="stylesheet" href="../css/index.css">
<link rel="stylesheet" href="../css/modal.css">
<div>
<div class="body-header">
        <div class="seletc_g">
            <div class="select_header">
                <div>
                    <a href="./index.php"><img class="icon_select" src="../icons/monitor (2).png"></a>
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

    <div class="container_body">
        <!-- TABELA DE INFORMAÇÕES DOS CONVÊNIOS CADASTRADOS -->
        <div class="container_son">
            <div>   
                <button class="btn_style" onclick="abrir_modal()">Cadastrar Convênio</button> 
            </div><br>
            <p>Convenios cadastrados no seu sistema</p>

            <table border="1px" ID="alter" cellpadding="10">
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Identificador</th>
                </thead>
                <tbody> 
                    <?php 
                    // COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
                    $sql_convenio   = "SELECT * FROM convenio";
                    $query_convenio = $mysqli->query($sql_convenio) or die($mysqli->error);
                    $num_convenio = $query_convenio->num_rows;
                    if($num_convenio == 0) { 
                        ?> 
                <tr>
                    <td colspan="7">Nenhum convênio foi encontrado!</td>
                </tr>
                <?php }
                    else{ 
                        while($convenio = $query_convenio->fetch_assoc()){
                    ?>     
                    <tr>
                        <td><?php echo $convenio['id']?>     </td>
                        <td><?php echo $convenio['nome']?>   </td>
                        <td><?php echo $convenio['codigo']?>  </td>
                        <td>
                            <a class="error" href="../Control/deletar_convenio.php?id=<?php echo $convenio['id']?>">Deletar</a>
                        </td>
                    </tr>             
                    <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>

        <!-- DIVISÃO DE MODAL CADASTRO DE CONVÊNIO CONTRALADA POR CSS/MODAL.CSS -->
        <div class="janela-modal" id="janela-modal">
            <div class="modal">
                <div>
                    <button class="fechar" id="fechar">X</button>
                    <form action="../Control/Post_CriarConvenio.php" method="POST">
                        <p>Cadastrar convênio em seu sistema</p><br><br>
                        <label>Nome Convênio</label>
                        <input name="nome" type="text"><br><br>
                        <label>Código convênio</label>
                        <input name="codigo" type="text"><br><br>
                        <button type="submit" class="btn_style">Enviar</button> 
                    </form>
                </div>
            </div>
    </div>
<script src="../src/modal.js"></script>
</body>
</html>