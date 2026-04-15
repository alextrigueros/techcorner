//Funcionalitat del botó de pujar a dalt de tot
//Seleccionem el botó
let botoPujar = document.getElementById("btnPujar");

//Quan l'usuari fa scroll, mirem si mostrar el botó
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    //Si hem baixat més de 300px, mostrem el botó
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        botoPujar.style.display = "block";
    } else {
        botoPujar.style.display = "none";
    }
}

//Quan es fa clic, pugem a dalt de tot
botoPujar.onclick = function () {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
};