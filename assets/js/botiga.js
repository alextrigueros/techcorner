//Guardar posició d'scroll abans de recarregar
window.addEventListener('beforeunload', () => {
    localStorage.setItem('adminScrollPos', window.scrollY);
});

//Restaurar posició scroll en carregar
window.addEventListener('load', () => {
    let scrollPos = localStorage.getItem('adminScrollPos');
    if (scrollPos) {
        window.scrollTo(0, parseInt(scrollPos));
        localStorage.removeItem('adminScrollPos'); //Netegem
    }
});


document.addEventListener('DOMContentLoaded', () => {
    let alerta = document.querySelector('.alerta-exit');
    
    if (alerta) {
        setTimeout(() => {
            alerta.style.transition = "opacity 0.5s ease";
            alerta.style.opacity = "0";
            
            setTimeout(() => {
                alerta.remove();
            }, 500);
            
        }, 1500); 
    }
});
