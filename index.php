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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sant imports</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="normalize.css">
</head>

<body >
    <!-- Header  *NAV* - Mensagem central superior -->
    <header class="h-g">
        <form class="h-f">
            <p>Text tittle</p>
        </form>
    <!-- *HEADER* Menu & Logo central  -->
        <img onclick="lmenu()" class="h-img" src="imagens/hamburger.png">
        <div id="lh" class="h-menu"><br>
            <a onclick="fmenu()">X</a>
            <b>Ofertas imperdíveis da black! ↓</b>
            <br><br>
            <a>Menu1</a><hr><br>
            <a href="logout.php">Encerrar sessão</a>
          
            <input type="text" id="search-bar" placeholder="Busca">
            <a><img class="input-lupa"src="imagens/pesquisa-de-lupa.png"></a>
                <div class="icons">
                    <img src="imagens/instagram.png">
                    <img src="imagens/facebook.png">
                    <img src="imagens/tiktok.png">
                    <img src="imagens/youtube.png">
                    <img src="imagens/whatsapp.png">
                </div>
        </div>

        <p>Olá, <b><?php echo $cliente['nome']?></b></p>
        <p></p>
    </header>


    <div class="nav-g">
        <div class="nav-item-title">
            <h1>Lançamentos - Masculinos</h1>
        </div>


    
        <div class="nav-email">
            <h1>Receba novidades no e-mail</h1><hr>
            <b>Cadastre-se e seja um dos primeiros a saber todas as novidades.</b><br><br>            </b>
            <input type="text" id="search-bar-email" placeholder="Digite seu email">
            <button>Cadastre-se</button><br><br>
            <img src="imagens/o-email.png">

        </div>

        <div class="nav-rodape">
            <div class="nav-social">
                <h1>Nossa redes sociais</h1>
                <img src="imagens/instagram.png">
                <img src="imagens/facebook.png">
                <img src="imagens/tiktok.png">
                <img src="imagens/youtube.png">
                <img src="imagens/whatsapp.png"><br>
                <b>@SantImports</b><br><br>
                <b>Rua Santa Genoveva, 217 - CEP: 06700505
                </b>
            </div>
            <div class="nav-social">
                <h1>Categorias</h1>
                <a src="#">Masculino</a><br>
                <!-- <a src="#">Feminino</a><br>
                <a src="#">Infantil</a><br>
                <a src="#">Acessórios</a><br>
                <a src="#">Buckets</a><br>
                <a src="#">Lançamentos</a><br> -->
            </div>
            <div class="nav-social">
                <h1>Contatos</h1>
                <a src="#">Trabalhe conosco</a><br>
                <!-- <a src="#">Suporte</a><br>
                <a src="#">Loja 1 - Endereço</a><br>
                <a src="#">Loja 1 - Endereço</a><br>
                <a src="#">Loja 1 - Endereço</a><br><hr>
                <b>santimports@mail.com.br</b> -->
            </div>
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>
