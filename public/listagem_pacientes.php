<?php 
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: index_login.php");
    }    
}
include('../Control/conexao.php');
include('../Control/function.php');


// Parâmetro para o número de pacientes por página
$pacientes_por_pagina = 6;

// Verifica se o parâmetro de página foi enviado, caso contrário, define como página 1
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcula o deslocamento para a consulta SQL
$offset = ($pagina_atual - 1) * $pacientes_por_pagina;

// Consulta para contar o número total de pacientes
$sql_total_pacientes = "SELECT COUNT(*) as total FROM pacientes";
$result_total = $mysqli->query($sql_total_pacientes) or die($mysqli->error);
$total_pacientes = $result_total->fetch_assoc()['total'];

// Calcula o número total de páginas
$total_paginas = ceil($total_pacientes / $pacientes_por_pagina);

// Consulta para buscar os pacientes da página atual
$sql_pacientes = "SELECT * FROM pacientes LIMIT $offset, $pacientes_por_pagina";
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
<!-- LINK CSS -->
<link rel="stylesheet" href="../estilos/style.css">
<!-- BIBLIOTECA SWEET MODAL -->
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<body>
    <!-- HEADER DE INFORMAÇÕES -->
    <header class="header">
        <nav>
            <ul class="list-header">
                <li>
                    <!-- PACIENTES -->
                    <a class="btn" href="   listagem_pacientes.php">Listagem Pacientes</a>
                </li>
                <li>
                    <!-- USUÁRIOS -->
                    <a class="btn" href="listagem_usuarios.php">Configurações de usuários</a>
                </li>
                <li>
                    <!-- EXAMES -->
                    <a class="btn" href="listagem_exames.php">Cadastro de exames</a>
                </li>
                <li>
                    <!-- RELATÓRIO -->
                    <a class="btn" href="relatorio_pacientes.php">Relatório</a>
                </li>
                <li>
                    <!-- SAIR -->
                    <a class="btn" href="Login_Lab/logout.php">Encerrar</a>
                </li>
            </ul>
        </nav>
    </header>
    <!-- FINAL HEADER -->

    <!-- TABELA DE PACIENTES CADASTRADOS -->
    <div class="container">
        <div class="container_son">
            <table cellpadding="10">
                <thead>
                    <th>
                        <button class="btn-cadastro" id="AbrirModal">Cadastrar Paciente</button>
                    </th>
                    <th colspan="9">
                        <h1>LISTAGEM DE PACIENTES</h1>
                    </th>
                </thead>
                <thead>
                    <th>Atendimento</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Celular</th>
                    <th>Data de cadastro</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    <?php 
            if($num_pacientes == 0) { ?>
                    <tr>
                        <td colspan="7">Nenhum paciente foi encontrado!</td>
                    </tr>
                    <?php } else { 
            while($pacientes = $query_pacientes->fetch_assoc()) {
                $telefone = "Não informado!";
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
                        <td><?php echo $pacientes['ID']?> </td>
                        <td><?php echo $pacientes['nome']?> </td>
                        <td><?php echo $pacientes['email']?> </td>
                        <td><?php echo $telefone; ?> </td>
                        <td><?php echo $data_cadastro;?> </td>
                        <td>
                            <a href="../public/editar_paciente.php?id=<?php echo $pacientes['ID']?>">Editar</a>
                            <hr>
                            <a href="../modules/deletar_paciente.php?id=<?php echo $pacientes['ID']?>">Deletar
                            </a>
                        </td>
                    </tr>
                    <?php 
            }
            } 
            ?>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="paginacao">
            <?php if ($pagina_atual > 1) { ?>
            <a href="?pagina=<?php echo $pagina_atual - 1; ?>">Página Anterior</a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
            <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $pagina_atual) echo 'style="font-weight:bold;"'; ?>>
                <?php echo $i; ?>
            </a>
            <?php } ?>

            <?php if ($pagina_atual < $total_paginas) { ?>
            <a href="?pagina=<?php echo $pagina_atual + 1; ?>">Próxima Página</a>
            <?php } ?>
        </div>
    </div>
    <!-- FINAL TABELA DE PACIENTES -->

    <!-- MODAL CADASTRADO DE PACIENTES -->
    <div class="container-modal" id="container-modal">
        <div class="janela-cadastro">
            <form action="../modules/Post.CriarPaciente.php" method=POST>
                <ul class=" lista-cadastro">
                    <button class="close">x</button>
                    <li>
                        <label>Nome.........:</label>
                        <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome">
                    </li>
                    <li>
                        <label>CPF............:</label>
                        <input type="text" value="<?php if(isset($_POST['CPF'])) echo $_POST['CPF']; ?>" name="CPF">
                    </li>
                    <li>
                        <label>RG.............:</label>
                        <input type="text" value="<?php if(isset($_POST['RG'])) echo $_POST['RG']; ?>" name="RG">
                    </li>
                    <li>
                        <label>E-mail........:</label>
                        <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"
                            name="email">
                    </li>
                    <li>
                        <label>Endereço....:</label>
                        <input type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>"
                            name="endereco">
                    </li>
                    <li>
                        <label>CEP............:</label>
                        <input type="text" value="<?php if(isset($_POST['CEP'])) echo $_POST['CEP']; ?>" name="CEP">
                    </li>
                    <li>
                        <label>Cidade........:</label>
                        <input type="text" value="<?php if(isset($_POST['cidade'])) echo $_POST['cidade']; ?>"
                            name="cidade">
                    </li>
                    <li>
                        <label>Nascimento:</label>
                        <input type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>"
                            name="nascimento" placeholder="dia/mês/ano">
                    </li>
                    <li>
                        <label>Telefone.....:</label>
                        <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>"
                            placeholder="11988888888" type="number" name="telefone">
                    </li>
                    <li class="li-sexo">
                        <label>Feminino</label>
                        <input type="radio" value="Feminino" name="sexo">
                        <label>Masculino</label>
                        <input type="radio" value="Masculino" name="sexo">
                    </li>
                    <li>
                        <button class="btn-cadastro" type="submit" name="cadastrar">Enviar</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    <!-- FINAL MODAL CADASTRO DE PACIENTES -->

    <!-- SWEET ALERTA PARA ERRO OU SUCESSO -->
    <?php
      if(isset($_SESSION['error']) && $_SESSION['error']) : 
        $error = $_SESSION['error']; 
        unset($_SESSION['error']);
    ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: '<?php echo $error; ?>',
        text: 'Verifique os campos preenchidos',
        confirmButtonText: 'Fechar'
    });
    </script>
    <?php endif;?>
    <?php
      if(isset($_SESSION['sucess']) && $_SESSION['sucess']) : 
            $sucess = $_SESSION['sucess']; 
            unset($_SESSION['sucess']);
      ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: '<?php echo $sucess; ?>',
        // text: '',
        confirmButtonText: 'fechar'
    });
    </script>
    <?php endif;?>

    <script src=" ../src/modal.js"></script>
</body>

</html>