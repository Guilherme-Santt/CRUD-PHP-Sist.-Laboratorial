<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Relatorio" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
</head>
<link rel="stylesheet" href="../estilos/style.css">
<!-- BIBLIOTECA PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
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
    <!-- END HEADER -->

    <!-- FORM PARA GERAR RELATÓRIO -->
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
                        <button class="btn-cadastro" type='submit'>Pesquisar</button>
                        <a class="btn-cadastro" id="generate-pdf">Imprimir</a>
                    </li>
                </ul>
            </form>
        </div>
    
    <!-- END GERADOR RELATÓRIO -->

    <!-- POSTS COM SQL PARA BUSCAR INFORMAÇÕES NO BANCO. NESTE CÓDIGO CONTÉM AS INFORMAÇÕES DA TABELA PACIENTES ASSOCIADO COM A PACIENTES_EXAMES E PUXANDO AS INFORMAÇÕES TAMBEM DA TABELA EXAMES -->
    <div class="info-content" id="content">
    <?php
        include('../Control/conexao.php');
        include('../Control/function.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtém as datas do formulário
            $dataInicial = $_POST['date_inicial'];
            $dataFinal = $_POST['date_final'];

            // Valida se as datas foram fornecidas
            if (!empty($dataInicial) && !empty($dataFinal)) {
                // Ajusta as datas para incluir horas
                $dataInicial .= " 00:00:00";
                $dataFinal .= " 23:59:59";

                // Consulta SQL com JOIN nas tabelas
                $sql = "
                    SELECT 
                        p.ID AS paciente_id,
                        p.nome,
                        p.data,
                        p.CPF,
                        p.RG,
                        p.telefone,
                        p.nascimento,
                        p.email,
                        CONCAT(p.endereco, ', ', p.cidade) AS endereco_completo,
                        p.sexo,
                        GROUP_CONCAT(e.descricao SEPARATOR ', ') AS descricao_exames,
                        SUM(e.valor) AS valor_total_exames
                    FROM 
                        pacientes AS p
                    LEFT JOIN 
                        pacientes_exames AS pe ON p.ID = pe.paciente_id
                    LEFT JOIN 
                        exames AS e ON pe.exame_id = e.exameid
                    WHERE 
                        p.data BETWEEN ? AND ?
                    GROUP BY 
                        p.ID
                ";

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
                                <li><b>Protocolo: </b>"             . htmlspecialchars($row['paciente_id']) . "</li>
                                <li><b>Cadastro: </b>"              . htmlspecialchars($dataFormatada) . "</li>
                                <li><b>CPF: </b>"                   . htmlspecialchars(formatar_cpf($row['CPF'])) . "</li>
                                <li><b>Registro Nacional: </b>"     . htmlspecialchars($row['RG']) . "</li>
                                <li><b>Celular: </b>"               . htmlspecialchars($row['telefone']) . "</li>
                                <li><b>Data nascimento: </b>"       . htmlspecialchars(formatar_data($row['nascimento'])) . "</li>
                                <li><b>E-mail: </b>"                . htmlspecialchars($row['email']) . "</li>
                                <li><b>Endereço: </b>"              . htmlspecialchars($row['endereco_completo']) . "</li>
                                <li><b>Sexo: </b>"                  . htmlspecialchars($row['sexo']) . "</li>
                                <li><b>Exames Realizados: </b>"     . htmlspecialchars($row['descricao_exames']) . "</li>
                                <li><b>Valor Total dos Exames: </b>R$" . htmlspecialchars(number_format($row['valor_total_exames'], 2, ',', '.')) . "</li>
                            </ul><hr>";
                        }
                    } else {
                        // Nenhum resultado encontrado
                        $error = "Nenhum paciente encontrado no intervalo fornecido.";
                    }

                    // Fecha o statement
                    $stmt->close();
                } else {
                    // Erro na preparação do statement
                    $error = "Erro ao preparar a consulta: " . $mysqli->error;
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