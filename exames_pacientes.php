<?php 
    include('conexao.php');
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
}
    $id = $_SESSION['usuario'];

    $sql_code = "SELECT * FROM exames";
    $query_code = $mysqli->query($sql_code);
    $exames = $query_code->fetch_assoc();
    
    $sql_code = "SELECT * FROM pacientes";
    $query_code = $mysqli->query($sql_code);
    $pacientes = $query_code->fetch_assoc();
    
    $sql_code = "SELECT pacientes.id as id_paciente, exames.nome as nome_exame, exames.codigo as codigo_exame, pacientes.nome as nome_paciente, exames.descricao as descricao_exame FROM pacientes_exames, pacientes, exames WHERE pacientes_exames.exame_id = exames.exameid AND pacientes_exames.paciente_id = pacientes.id;";
    $query_code = $mysqli->query($sql_code);
    $num_clientes = $query_code->num_rows;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>    

    <table border="1" cellpadding="10">
                <thead>
                    <th>Nome</th>
                    <th>Código exame</th>
                    <th>Nome exame</th>
                    <th>Descrição exame</th>

                </thead>
                <tbody> 
                <?php 
                    if($num_clientes == 0) { 
                ?> 
                <tr>
                    <td colspan="7">Nenhum usuário foi encontrado!</td>
                </tr>
                <?php }
                    else{ 
                        while($pacientes_exames = $query_code->fetch_assoc()){

                    ?>     
                    <tr>
                        <td><?php echo $pacientes_exames['nome_paciente']; ?> </p>  </td>
                        <td><?php echo  $pacientes_exames['codigo_exame']; ?> </p>   </td>
                        <td><?php echo $pacientes_exames['nome_exame']; ?> </p> </td>
                        <td><?php echo $pacientes_exames['descricao_exame']; ?> </p>  </td>
                        <td>
                        <a class="edit" href="editar_exames_pacientes.php?id=<?php echo $pacientes_exames['id_paciente']?>">Editar</a>
                        <a class="error" href="deletar_usuario.php?id=<?php echo $$pacientes_exames['id_paciente']?>">Deletar</a>
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