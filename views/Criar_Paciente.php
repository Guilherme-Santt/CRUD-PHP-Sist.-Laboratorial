<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
$id = $_SESSION['usuario'];
include('conexao.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="../css/index.css">
<body>
       <!-- HEADER SUPERIOR -->
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
                    <img onclick="abrir_modal()" class="icon_select" src="../icons/calendario.png">
                </div>
                <div>
                    <h3>
                        Sugestões
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
        <div class="container_son">
            <form action="../Control/Post_CriarPacienteCompleto.php" method="POST">
                    <label>Nome</label>
                    <input  type="text" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome">
                    
                    <label>CPF</label>
                    <input  type="text" value="<?php if(isset($_POST['CPF'])) echo $_POST['CPF']; ?>" name="CPF">

                    <label>RG</label>
                    <input  type="text" value="<?php if(isset($_POST['RG'])) echo $_POST['RG']; ?>" name="RG">

                    <label>E-mail</label>
                    <input  type="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" name="email">

                    <label>Endereço</label>
                    <input  type="text" value="<?php if(isset($_POST['endereco'])) echo $_POST['endereco']; ?>" name="endereco">
                    
                    <label>CEP</label>
                    <input  type="text" value="<?php if(isset($_POST['CEP'])) echo $_POST['CEP']; ?>" name="CEP"><br><br>
                    
                    <label>Nome da mãe</label>
                    <input  type="text" value="<?php if(isset($_POST['mae'])) echo $_POST['mae']; ?>" name="mae">

                    <label>Cidade</label>
                    <input  type="text" value="<?php if(isset($_POST['cidade'])) echo $_POST['cidade']; ?>" name="cidade">

                    <label>Nascimento</label>
                    <input  type="date" value="<?php if(isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" placeholder="dia/mês/ano">

                    <label>CRM</label>
                    <input  type="text" value="<?php if(isset($_POST['CRM'])) echo $_POST['CRM']; ?>" name="CRM" placeholder="CRM do médico">

                    <label>Convênio</label>
                    <input  type="text" value="<?php if(isset($_POST['convenio'])) echo $_POST['convenio']; ?>" name="convenio"><br><br>

                    
                    <label>Diagnostico</label>
                    <input  type="text" value="<?php if(isset($_POST['diagnostico'])) echo $_POST['diagnostico']; ?>" name="diagnostico">

                    <label>Medicamentos</label>
                    <input  type="text" value="<?php if(isset($_POST['medicamentos'])) echo $_POST['medicamentos']; ?>" name="medicamentos">

                    <label>Observações</label>
                    <input  type="text" value="<?php if(isset($_POST['observacoes'])) echo $_POST['observacoes']; ?>" name="observacoes">
                        
                    <label>Telefone:</label>
                    <input  value ="<?php if(isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="11988888888" type="text" name="telefone"><br><br>
                        
                    <input type="radio" value="Feminino" name="sexo">Feminino
                    <input type="radio" value="Masculino" name="sexo">Masculino<br><br>

                    <button type="submit" name="cadastrar">Salvar</button>
                </form>
        </div> 
    </div>

</body>
</html>