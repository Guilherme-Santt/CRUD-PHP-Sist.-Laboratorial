function abrir_modal_convenio(){
    const modal = document.getElementById('janela-modal-convenio')
    modal.classList.add('abrir')
    
    modal.addEventListener('click', (e) => {
        if(e.target.id == 'fechar' ||e.target.id == 'janela-modal-convenio')
            modal.classList.remove('abrir')
    })
    }