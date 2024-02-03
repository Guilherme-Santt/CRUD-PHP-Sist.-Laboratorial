<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container_body">
            <!-- TABELA DE INFORMAÇÕES DOS MÉDICOS CADASTRADOS -->
            <div class="container_son">
            <div>   
                <button class="btn_style" onclick="abrir_modal_medico()">Cadastrar Médico</button> 
            </div><br>
            <p>Médicos cadastrados no seu sistema</p>
   
            <table border="1px" ID="alter" cellpadding="10">
                <thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CRM</th>
                </thead>
                <tbody> 
                    <?php 
                    // COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
                    $sql_medicos   = "SELECT * FROM medicos";
                    $query_medicos = $mysqli->query($sql_medicos) or die($mysqli->error);
                    $num_medicos = $query_medicos->num_rows;
                    if($num_medicos == 0) { 
                        ?> 
                <tr>
                    <td colspan="7">Nenhum usuário foi encontrado!</td>
                </tr>
                <?php }
                    else{ 
                        while($medico = $query_medicos->fetch_assoc()){
                    ?>     
                    <tr>
                        <td><?php echo $medico['id']?>     </td>
                        <td><?php echo $medico['nome']?>   </td>
                        <td><?php echo $medico['CRM']?>     </td>
                        <td>
                            <a class="error" href="../Control/deletar_medico.php?id=<?php echo $medico['id']?>">Deletar</a>
                        </td>
                    </tr>             
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>  
    </div>

</body>
</html>