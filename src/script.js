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

