function abrir_modal_medico(){
    const modal = document.getElementById('janela-modal-medico')
    modal.classList.add('abrir')
    
    modal.addEventListener('click', (e) => {
        if(e.target.id == 'fechar' ||e.target.id == 'janela-modal-medico')
            modal.classList.remove('abrir')
    })
    }