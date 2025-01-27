<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../Control/conexao.php');
include('../Control/function.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exames</title>
</head>
<!-- CÓDIGOS CSS -->
<link rel="stylesheet" href="../estilos/style.css">
<!--===============================================================================================-->	
<!-- BIBLIOTECA SWEET MODAL -->
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<body>
    <!-- HEADER DE INFORMAÇÕES -->
    <header class="header">
        <nav>
            <ul class="list-header">
                <!-- PACIENTES -->
                <li>
                    <a class="btn" href="listagem_pacientes.php">Listagem Pacientes</a>
                </li>

                <!-- USUÁRIOS -->
                <li>
                    <a class="btn" href="listagem_usuarios.php">Configurações de usuários</a>
                </li>

                <!-- EXAMES -->
                <li>
                    <a class="btn" href="listagem_exames.php">Cadastro de exames</a>
                </li>
                <li>
                    <!-- SAIR -->
                    <a class="btn" href="Login_Lab/logout.php">Encerrar</a>
                </li>
            </ul>
        </nav>
    </header>
    <!-- DIV PARA TABELA COM INFORMAÇÕES DOS EXAMES -->
    <div class="container">
        <div class="container_son">
            <?php
          // Parâmetro para o número de visualizações por página
          $exames_por_pagina = 6;

          // Verifica se o parâmetro de página foi enviado, caso contrário, define como página 1
          $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

          // Calcula o deslocamento para a consulta SQL
          $offset = ($pagina_atual - 1) * $exames_por_pagina;

          // Consulta para contar o número total de exames
          $sql_total_exames = "SELECT COUNT(*) as total FROM exames";
          $result_total = $mysqli->query($sql_total_exames) or die($mysqli->error);
          $total_exames = $result_total->fetch_assoc()['total'];

          // Calcula o número total de páginas
          $total_paginas = ceil($total_exames / $exames_por_pagina);

          // Consulta para buscar os exames da página atual
          $sql_exames = "SELECT * FROM exames LIMIT $offset, $exames_por_pagina";
          $query_exames = $mysqli->query($sql_exames) or die($mysqli->error);
        ?>

            <table>
                <thead>
                    <th>
                        <button class="btn-cadastro" id="AbrirModal">Cadastrar exame</button>
                    </th>
                    <th colspan="4">
                        <h1>CADASTRO DE EXAMES</h1>
                    </th>
                </thead>
                <thead>
                    <th>Código</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ação</th>
                </thead>
                <tbody>
                    <?php 
        if($query_exames->num_rows == 0) { 
        ?>
                    <tr>
                        <td colspan="5">Nenhum exame foi encontrado!</td>
                    </tr>
                    <?php 
        } else { 
            while($exames = $query_exames->fetch_assoc()) {
        ?>
                    <tr>
                        <!-- VISUALIZAÇÃO DOS CAMPOS NA TABELA -->
                        <td><?php echo $exames['codigo']?> </td>
                        <td><?php echo $exames['descricao']?> </td>
                        <td><?php echo $exames['valor'];?> </td>
                        <td><a href="../modules/deletar_exame.php?id=<?php echo $exames['exameid'] ?>">Deletar exame</a>
                        </td>
                    </tr>
                    <?php 
            }
        } 
        ?>
                </tbody>
            </table>

            <!-- Paginação -->
            <div class="paginacao">
                <?php if ($pagina_atual > 1) { ?>
                <a href="?pagina=<?php echo $pagina_atual - 1; ?>"><<</a>
                <?php } ?>
    
                <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                    <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $pagina_atual) echo 'style="font-weight:bold;"';?>><?php echo $i;?></a>
                <?php } ?>
    
                <?php if ($pagina_atual < $total_paginas) { ?>
                <a href="?pagina=<?php echo $pagina_atual + 1; ?>">>></a>
                <?php } ?>
            </div>
        </div>
        <!-- END VISUALIZAÇÃO DE EXAMES NO SISTEMA -->

        <!-- JANELA MODAL->CADASTRO DE EXAMES NO SISTEMA -->
        <div class="container-modal" id="container-modal">
            <div class="janela-cadastro">
                <form action="../modules/Post_CriarExames.php" method="POST">
                    <button class="close">x</button>
                    <ul class="lista-cadastro">
                        <li>
                            <label>Código......:</label>
                            <input type="text" value="<?php if(isset($_POST['codigo'])) echo $_POST['codigo']; ?>"
                                name="codigo">
                        </li>
                        <li>
                            <label>Descrição..:</label></label>
                            <input type="text" value="<?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?>"
                                name="descricao">
                        </li>
                        <li>
                            <label>Valor.........:</label></label>
                            <input type="text" value="<?php if(isset($_POST['valor'])) echo $_POST['valor']; ?>"
                                name="valor">
                        </li>
                        <li>
                            <button class="btn-cadastro" type="submit" name="cadastrar">Enviar</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <!-- END MODAL -->
    </div>
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

    <script src="../src/modal.js"></script>
</body>

</html>