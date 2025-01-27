<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Relatorio" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="../estilos/style.css">
<!-- BIBLIOTECA PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

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

    <div class="container">
        <div class="att-infos">
            <form action="" method="POST">
                <ul>
                    <b> Selecione o intervalo de data dos paciente que deseja</b>
                    <li>
                        <label for="dataHoje">Data inicio</label>
                        <input type="date" name="date_inicial" id="dataHoje">
                        <label for="dataHoje">Data fim</label>
                        <input type="date" name="date_final" id="dataHoje2">
                    </li>
                    <li>
                        <button class="btn-cadastro" type='submit'>Gerar Relatório</button>
                        <a class="btn-cadastro" id="generate-pdf">Gerar PDF</a>
                    </li>
                </ul>
            </form>
        </div>
        <div class="info-content" id="content">
            <?php
            include('../Control/conexao.php');
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtém as datas do formulário
                $dataInicial = $_POST['date_inicial'];
                $dataFinal = $_POST['date_final'];

                // Valida se as datas foram fornecidas
                if (!empty($dataInicial) && !empty($dataFinal)) {
                // Ajusta as datas para incluir horas
                $dataInicial .= " 00:00:00";
                $dataFinal .= " 23:59:59";

                // Prepara a consulta SQL
                $sql = "SELECT * FROM pacientes WHERE data BETWEEN ? AND ?";
                $stmt = $mysqli->prepare($sql);

                if ($stmt) {
                // Bind dos parâmetros
                $stmt->bind_param("ss", $dataInicial, $dataFinal);

                // Executa a consulta
                $stmt->execute();
                $result = $stmt->get_result();

                // Verifica se encontrou resultados
                if ($result->num_rows > 0) {
                $sucess = "Relatório gerado com sucesso";
                
                    // Exibe os resultados
                    while ($row = $result->fetch_assoc()) {
                        $data = new DateTime($row['data']);

                    // Formatar a data em outro formato, por exemplo: "d/m/Y H:i:s"
                    $dataFormatada = $data->format('d/m/Y H:i:s');

                    echo "
                    <ul>
                    <li><b>Nome: </b>"                  . htmlspecialchars($row['nome']) . "</li>
                    <li><b>Protocolo: </b>"             . htmlspecialchars($row['ID']) . "</li>
                        <li><b>Cadastro: </b>"          . htmlspecialchars($dataFormatada) . "</li>
                        <li><b>CPF: </b>"               . htmlspecialchars($row['CPF']) . "</li>
                        <li><b>Registro Nacional: </b>" . htmlspecialchars($row['RG']) . "</li>
                        <li><b>Celular: </b>"           . htmlspecialchars($row['telefone']) . "</li>
                        <li><b>Data nascimento: </b>"   . htmlspecialchars($row['nascimento']) . "</li>
                        <li><b>E-mail: </b>"            . htmlspecialchars($row['email']) . "</li>
                        <li><b>Endereço: </b>"          . htmlspecialchars($row['endereco'] . ", " . $row['cidade']) . "</li>
                        <li><b>Sexo: </b>"              . htmlspecialchars($row['sexo']) . "</li>
                    </ul><hr>";

                    }
            } else {
            // Nenhum resultado encontrado
            $error = "Nenhum paciente encontrado no intervalo fornecido." ;
            }

            // Fecha o statement
            $stmt->close();
            } else {
            // Erro na preparação do statement
            $error  = "Erro ao preparar a consulta: " . $mysqli->error ;
            }
            } else {
            // Mensagem de erro se as datas não forem fornecidas
            $error = "Por favor, insira as datas inicial e final";
            }
            }

            ?>
        </div>
    </div>
    <!-- SWEET ALERTA PARA ERRO OU SUCESSO -->
    <?php
      if(isset($error) && $error) :?>
    <script>
    Swal.fire({
        icon: 'error',
        title: '<?php echo $error; ?>',
        // text: '',
        confirmButtonText: 'Fechar'
    });
    </script>
    <?php endif;?>
    <?php
      if(isset($sucess) && $sucess) :?>
    <script>
    Swal.fire({
        icon: 'success',
        title: '<?php echo $sucess; ?>',
        // text: '',
        confirmButtonText: 'fechar'
    });
    </script>
    <?php endif;?>
    <script src="../src/script.js"></script>
</body>

</html>