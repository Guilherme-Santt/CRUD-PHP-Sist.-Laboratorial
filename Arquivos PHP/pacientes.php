<?php 
include('conexao.php');


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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>         
    <a href="index.php">Retornar pagina inicial</a> 
    <a href="cadastro_pacientes.php">Cadastrar Pacientes</a>      
    <h1>Listagem de pacientes</h1>
    <p>Esses são os pacientes cadastrados no seu sistema</p>
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
            <?php 
                include('conexao.php');
                // COMANDO SQL PARA CONSULTAR QUANTIDADE DE CLIENTES NO SISTEMA
                $sql_pacientes   = "SELECT * FROM pacientes";
                $query_pacientes = $mysqli->query($sql_pacientes) or die($mysqli->error);
                $num_pacientes = $query_pacientes->num_rows;
                if($num_pacientes == 0) { 
            ?> 
            <tr>
                <td colspan="7">Nenhum paciente foi encontrado!</td>
            </tr>
            <?php }
                else{ 
                    while($pacientes = $query_pacientes->fetch_assoc()){
                        $telefone ="Não informado!";
                        if(!empty($pacientes['telefone'])){
                            $telefone = formatar_telefone($pacientes['telefone']);   
                        }
                            $nascimento = "Nascimento não informada!";
                        if(!empty($pacientes['nascimento'])){
                             $nascimento = formatar_data($pacientes['nascimento']);
                            }
                            $data_cadastro = date("d/m/y H:i:s", strtotime($pacientes['data']));
            ?>     
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
    </table>
</body>
</html>