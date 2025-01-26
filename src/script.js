console.log("O JavaScrt está funcionando");

// GERADOR DE PDF
const btnGenerate = document.querySelector("#generate-pdf")

btnGenerate.addEventListener("click", () => {
    console.log("Usuario clicou em gerar PDF")
        // CONTEUDO GERADO NO PDF
    const conteudo = document.querySelector("#content");
    const btnPDF = document.querySelector("#btnPdf");

    if (!conteudo) {
        console.error("Elemento com ID 'infos-paciente' não encontrado.");
        return;
    }

    //CONFIGURAÇÃO DO ARQUIVO PDF
    const options = {
        margin: [10, 10, 10, 10],
        filename: "relatorio.pdf",
        html2canvas: { scale: 2 },
        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
    };

    // GERAR E BAIXAR O PDF 
    html2pdf().set(options).from(conteudo).save();
});



// DATA DE HOJE
document.addEventListener("DOMContentLoaded", function() {
    // Seleciona o input de data
    let inputDate = document.getElementById("dataHoje");
    let inputDate2 = document.getElementById("dataHoje2");


    // Obtém a data atual
    const hoje = new Date();
    const ano = hoje.getFullYear();
    const mes = String(hoje.getMonth() + 1).padStart(2, '0'); // Adiciona zero à esquerda
    const dia = String(hoje.getDate()).padStart(2, '0'); // Adiciona zero à esquerda

    // Formata a data como YYYY-MM-DD
    const dataFormatada = `${ano}-${mes}-${dia}`;

    // Define o valor do input como a data atual
    inputDate.value = dataFormatada;
    inputDate2.value = dataFormatada;

});