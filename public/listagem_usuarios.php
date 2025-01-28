<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: Login_Lab/index_login.php");
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
    <title>Usuários</title>
</head>
<!-- ARQUIVOS CSS SITE -->
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
                <img class="img-worklab" src="../images/icons/worklab.png">
                <li>
                    <!-- PACIENTES -->
                    <img class="img-icon"src="../images/icons/pacientes.png">
                    <a class="btn" href="listagem_pacientes.php">Pacientes</a>
                </li>
                <li>
                    <!-- RELATÓRIO -->
                    <img class="img-icon" src="../images/icons/relatorio.png">
                    <a class="btn" href="relatorio_pacientes.php">Relatório</a>
                </li>
                <li>
                    <li>
                        <!-- EXAMES -->
                        <img class="img-icon" src="../images/icons/exames.png">
                        <a class="btn" href="listagem_exames.php">Exames</a>
                    </li>
                <li>
                    <!-- USUÁRIOS -->
                    <img class="img-icon"src="../images/icons/usuario.png">
                    <a class="btn" href="listagem_usuarios.php">Usuários</a>
                </li>
                <li>
                    <!-- SAIR -->
                    <img class="img-icon" src="../images/icons/encerrar.png">
                    <a class="btn" href="../modules/logout.php">Encerrar</a>
                </li>
            </ul>
        </nav>
    </header>
    <!-- FINAL HEADER -->


    <!-- DIVISÃO GERAL DAS INFORMAÇÕES NO CONTAINER -->
    <div class="container">
        <!-- TABELA DE USUARIOS CADASTRADOS LABORATÓRIO -->
        <div class="container_son">
            <?php
            // Número máximo de usuários por página
            $usuarios_por_pagina = 6;

            // Página atual, obtida via GET, padrão é 1
            $pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

            // Calcula o deslocamento para a consulta SQL
            $offset = ($pagina_atual - 1) * $usuarios_por_pagina;

            // Consulta para contar o número total de usuários
            $sql_total_clientes = "SELECT COUNT(*) as total FROM clientes";
            $result_total = $mysqli->query($sql_total_clientes) or die($mysqli->error);
            $total_usuarios = $result_total->fetch_assoc()['total'];

            // Calcula o número total de páginas
            $total_paginas = ceil($total_usuarios / $usuarios_por_pagina);

            // Consulta para buscar os usuários da página atual
            $sql_clientes = "SELECT * FROM clientes LIMIT $offset, $usuarios_por_pagina";
            $query_clientes = $mysqli->query($sql_clientes) or die($mysqli->error);
            $num_clientes = $query_clientes->num_rows;
            ?>
            <div class="container_son">
                <table ID="alter" cellpadding="10">
                    <thead>
                        <th>
                            <button class="btn-cadastro" id="AbrirModal">Cadastrar usuários</button>
                        </th>
                        <th colspan="9">
                            <h1> USUÁRIOS</h1>
                        </th>
                    </thead>
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
            if($num_clientes == 0) { ?>
                        <tr>
                            <td colspan="7">Nenhum usuário foi encontrado!</td>
                        </tr>
                        <?php 
            } else {
                while($cliente = $query_clientes->fetch_assoc()) {
                    $telefone = "Não informado!";
                    if(!empty($cliente['telefone'])){
                        $telefone = formatar_telefone($cliente['telefone']);   
                    }

                    $nascimento = "Nascimento não informada!";
                    if(!empty($cliente['nascimento'])){
                        $nascimento = formatar_data($cliente['nascimento']);
                    }

                    $data_cadastro = date("d/m/y H:i:s", strtotime($cliente['data']));
                ?>
                        <tr>
                            <td><?php echo $cliente['id']?> </td>
                            <td><?php echo $cliente['nome']?> </td>
                            <td><?php echo $cliente['email']?> </td>
                            <td><?php echo $telefone; ?> </td>
                            <td><?php echo $data_cadastro;?> </td>
                            <td>
                                <a class="edit" href="editar_usuario.php?id=<?php echo $cliente['id']?>">Editar</a>
                                <hr>
                                <a class="error"
                                    href="../modules/deletar_usuario.php?id=<?php echo $cliente['id']?>">Deletar</a>
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
                <a href="?pagina=<?php echo $pagina_atual - 1; ?>"><<</a>
                <?php } ?>

                <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $pagina_atual) echo 'style="font-weight:bold;"'; ?>>
                    <?php echo $i; ?>
                </a>
                <?php } ?>

                <?php if ($pagina_atual < $total_paginas) { ?>
                <a href="?pagina=<?php echo $pagina_atual + 1; ?>">>></a>
                <?php } ?>
            </div>
        </div>
        <!-- END VISUALIZAÇÃO DE USUARIOS -->


        <!-- MODAL CADASTRO DE USUARIOS -->
        <div class="container-modal" id="container-modal">
            <div class="janela-cadastro">
                <form action="../modules/PostCriarUsuario.php" method="POST">
                    <ul class="lista-cadastro">
                        <button class="close">x</button>
                        <li>
                            <label>Email.........:</label>
                            <input type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"
                                name="email">
                        </li>

                        <li>
                            <label>Nome.........:</label>
                            <input type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>"
                                name="nome">
                        </li>

                        <li>
                            <Label> Nascimento.:</Label>
                            <input type="date"
                                value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>"
                                name="nascimento">
                        </li>
                        <li>
                            <label>Telefone.....:</label>
                            <input value="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>"
                                placeholder="11988888888" type="text" name="telefone">
                        </li>
                        <li>
                            <label>Senha........:</label>
                            <input type="password" value="<?php if(isset($_POST['senha'])) echo $_POST['senha']; ?>"
                                name="senha">
                        </li>
                        <li>
                            <button class="btn-cadastro" type="submit" name="cadastrar">Enviar </button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <!-- END MODAL -->

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
        // text: 'Verifique os campos preenchidos',
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