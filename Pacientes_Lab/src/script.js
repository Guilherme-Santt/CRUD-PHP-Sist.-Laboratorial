// GERADOR DE PDF
const btnGenerate = document.querySelector("#generate-pdf");

btnGenerate.addEventListener("click", () => {
    console.log("Usuario clicou em gerar PDF")
    // CONTEUDO GERADO NO PDF
    const conteudo = document.querySelector("#content");
    if (!conteudo) {
        console.error("Elemento com ID 'infos-paciente' não encontrado.");
        return;
    }
    
    //CONFIGURAÇÃO DO ARQUIVO PDF
    const options = {
        margin: [10, 10, 10, 10],
        filename: "arquivo.pdf",
        html2canvas: { scale :2 },
        jsPDF: {unit: "mm", format: "a4", orientation: "portrait"},
    };

    // GERAR E BAIXAR O PDF 
    html2pdf().set(options).from(conteudo).save();
});
