<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<link rel="stylesheet" href="estilos/style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>


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
                    <b> Selecione o intervalo de data que deseja</b>
                    <li>
                        <label for="dataHoje">Data inicio</label>
                        <input type="date" name="date_inicial" id="dataHoje">
                        <label for="dataHoje">Data fim</label>
                        <input type="date" name="date_final" id="dataHoje">
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
            include('Control/conexao.php');
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
            echo "<h2>Relatório de Pacientes</h2>";
            
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
            echo "<p>Nenhum paciente encontrado no intervalo fornecido.</p>";
            }

            // Fecha o statement
            $stmt->close();
            } else {
            // Erro na preparação do statement
            echo "<p>Erro ao preparar a consulta: " . $mysqli->error . "</p>";
            }
            } else {
            // Mensagem de erro se as datas não forem fornecidas
            echo "<p>Por favor, insira as datas inicial e final.</p>";
            }
            }

            ?>
        </div>
    </div>

    <script src="./src/script.js"></script>
</body>

</html>