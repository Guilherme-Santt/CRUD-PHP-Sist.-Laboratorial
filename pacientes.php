<?php 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>                
    <h1>Usuários cadastrados</h1>
    <p>Esses são os usuários cadastrados no seu sistema</p>
    <table border="1" cellpadding="10">
        <thead>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Data de cadastro</th>
            <th>Ações</th>
        </thead>
        <tbody> 
            <?php 
                include('conexao.php');
                // COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
                $sql_pacientes   = "SELECT * FROM pacientes";
                $query_pacientes = $mysqli->query($sql_pacientes) or die($mysqli->error);
                $num_pacientes = $query_pacientes->num_rows;
                if($num_pacientes == 0) { 
            ?> 
            <tr>
                <td colspan="7">Nenhum usuário foi encontrado!</td>
            </tr>
            <?php }
                else{ 
                    while($pacientes = $query_pacientes->fetch_assoc()){
                        $telefone ="Não informado!";
                        if(!empty($paciente['telefone'])){
                            $telefone = formatar_telefone($cliente['telefone']);   
                        }
                            $nascimento = "Nascimento não informada!";
                        if(!empty($paciente['nascimento'])){
                             $nascimento = formatar_data($cliente['nascimento']);
                            }
                            $data_cadastro = date("d/m/y H:i:s", strtotime($cliente['data']));
            ?>     
            <tr>
                <td><?php echo $cliente['id']?>     </td>
                <td><?php echo $cliente['nome']?>   </td>
                <td><?php echo $cliente['email']?>  </td>
                <td><?php echo $telefone; ?>  </td>
                <td><?php echo $nascimento ?>   </td>
                <td><?php echo $data_cadastro;?>    </td>
                <td>
                <a class="edit" href="editar_usuario.php?id=<?php echo $cliente['id']?>">Editar</a>
                <a class="error" href="deletar_usuario.php?id=<?php echo $cliente['id']?>">Deletar</a>
                </td>
            </tr>             
            <?php
                    }
                }
                ?>
        </tbody>
    </table>
</body>
</html>