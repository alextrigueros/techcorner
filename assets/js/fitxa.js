//Restaurar posició scroll en carregar
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}

//Forçar scroll a dalt de tot en carregar
window.addEventListener('load', () => {

    window.scrollTo(0, 0);

});

//Funció per canviar la imatge principal quan es fa clic en una miniatura
function canviarImatge(novaRuta) {
    document.getElementById('imatge-principal').src = novaRuta;
}

//Funció per mostrar una alerta d'èxit i després desaparèixer-la
document.addEventListener('DOMContentLoaded', () => {
    let alerta = document.querySelector('.alerta-exit');

    if (alerta) {
        // Esperem 1 segon i llavors executem la desaparició
        setTimeout(() => {
            //Afegim una transició suau
            alerta.style.transition = "opacity 0.5s ease";
            alerta.style.opacity = "0";

            //Un cop acabada la transició eliminem el missatge del DOM
            setTimeout(() => {
                alerta.remove();
            }, 500);

        }, 1500);
    }
});