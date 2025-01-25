let MyModal = document.getElementById('container-modal');
var btn = document.getElementById('AbrirModal');
var span = document.getElementsByClassName("close")[0];
// Abrir modal
btn.onclick = function() {
    MyModal.style.display = "block";
    MyModal.classList.add("show");
}

// Fechar modal
span.onclick = function() {
        MyModal.style.display = "none";
        MyModal.classList.remove("show");


    }
    // Fechar modal em qualquer área da tela

window.onclick = function(event) {
    if (event.target == MyModal) {
        MyModal.style.display = "none";
        MyModal.classList.remove("show");
    }
}

// GERADOR DE PDF
const btnGenerate = document.querySelector("#generate-pdf")

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
        html2canvas: { scale: 2 },
        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
    };

    // GERAR E BAIXAR O PDF 
    html2pdf().set(options).from(conteudo).save();
});