<?php
    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION['usuario'])){
            die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
        }    
}
    include('conexao.php');
    $id = $_SESSION['usuario'];
    $sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
    $query = $mysqli->query($sqlcode);
    $cliente = $query->fetch_assoc();

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
    <title>Sant imports</title>
    <link rel="stylesheet" href="../Arquivos CSS/index.css">
    <link rel="stylesheet" href="../Arquivos CSS/normalize.css">
</head>

<body >
    <!-- Header  *NAV* - Mensagem central superior -->
    <header class="h-g">
        <form class="h-f">
            <p class="white">Olá, <b><?php echo $cliente['nome']?></b></p>
        </form>
        <!-- *HEADER* Menu & Logo central  -->
        <img onclick="lmenu()" class="h-img" src="../imagens/hamburger.png">
        <div id="lh" class="h-menu"><br>
            <a onclick="fmenu()">X</a>
            <Ul>
                <a href="usuarios.php"><li>Usuários</li></a>
                <a href="pacientes.php"><li>Listagem de pacientes</li></a>
                <a href="cadastro_pacientes.php"><li>Cadastro de pacientes</li></a>
                <a href="exames.php"><li>Cadastro de exames</li></a>
                <a href="logout.php"><li>Encerrar sessão</li></a>
            </Ul>
        </div>
    <p class="white">Unidade: <b><?php echo $cliente['unidade']?></b></p>
    </header>
    
    <script src="../Arquivos JS/index.js"></script>
</body>
</html>
