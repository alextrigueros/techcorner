//Script per a gestionar la previsualització de les imatges al formulari d'afegir producte a l'adminpanel.
//Permet veure les imatges seleccionades abans d'enviar el formulari i també eliminar-les si es vol.
//També permet afegir imatges secundàries de forma acumulativa.

//Seleccionem els elements de l'HTML
let inputPrincipal = document.getElementById('imatge_principal');
let inputSecundaries = document.getElementById('imatges_secundaries');

//Divs on mostrarem les previsualitzacions
let divPreviewPrincipal = document.getElementById('previsualitzacio-principal');
let divPreviewSecundaries = document.getElementById('previsualitzacio-secundaries');

//Aquesta llista guardarà tots els fitxers secundaris que anem afegint
let llistaFitxersSecundaris = [];

//Quan l'usuari selecciona una imatge principal, la previsualitzem
inputPrincipal.addEventListener('change', function () {
    divPreviewPrincipal.innerHTML = ""; //Netegem si hi havia una anterior

    let fitxer = this.files[0];
    if (fitxer) {
        //Utilitzem FileReader per a llegir el fitxer i mostrar-lo com a imatge
        let lector = new FileReader();
        //Quan el fitxer estigui carregat, creem una imatge i la mostrem al div
        //function(e) rep l'event de càrrega del FileReader, on e.target.result és la URL de la imatge
        lector.onload = function (e) {
            let img = document.createElement('img');
            img.src = e.target.result;
            divPreviewPrincipal.appendChild(img);
        }
        //Lectura del fitxer com a URL per a la previsualització
        lector.readAsDataURL(fitxer);
    }
});

//Quan l'usuari selecciona imatges secundàries, les afegim a la nostra llista i les previsualitzem
inputSecundaries.addEventListener('change', function () {
    //Afegim els nous fitxers seleccionats a la nostra llista global
    let nousFitxers = Array.from(this.files);

    for (let i = 0; i < nousFitxers.length; i++) {
        llistaFitxersSecundaris.push(nousFitxers[i]);
    }
    actualitzarPrevisualitzacioSecundaria();
    sincronitzarInput();
});

//Funció per dibuixar les miniatures de les imatges secundàries
function actualitzarPrevisualitzacioSecundaria() {
    divPreviewSecundaries.innerHTML = "";

    //Recorrem la llista de fitxers secundaris i creem una previsualització per a cada un
    for (let i = 0; i < llistaFitxersSecundaris.length; i++) {
        let fitxer = llistaFitxersSecundaris[i];
        let index = i;
        let lector = new FileReader();
        lector.onload = function (e) {
            let contenidorImg = document.createElement('div');

            let img = document.createElement('img');
            img.src = e.target.result;

            //Botó per si l'usuari vol treure esborrar una imatge de la llista
            let botoEsborrar = document.createElement('button');
            botoEsborrar.innerText = "X";
            botoEsborrar.type = "button";
            botoEsborrar.onclick = function () {
                eliminarImatge(index);
            };

            contenidorImg.appendChild(img);
            contenidorImg.appendChild(botoEsborrar);
            divPreviewSecundaries.appendChild(contenidorImg);
        }
        lector.readAsDataURL(fitxer);
    };
}

//Funció per eliminar una imatge de la llista
function eliminarImatge(index) {
    llistaFitxersSecundaris.splice(index, 1);
    actualitzarPrevisualitzacioSecundaria();
    sincronitzarInput();
}

//Funció que posa la llista de JS dins de l'input real de PHP
function sincronitzarInput() {
    //DataTransfer és una interfície que ens permet crear una llista de fitxers artificial per a assignar-la
    //a l'input de fitxers, ja que no podem modificar inputSecundaries.files des de JavaScript per a afegir o eliminar fitxers.
    let contenidorData = new DataTransfer();

    for (let i = 0; i < llistaFitxersSecundaris.length; i++) {
        //Afegim cada fitxer de la nostra llista al DataTransfer
        contenidorData.items.add(llistaFitxersSecundaris[i]);
    }

    //Assignem la llista de fitxers artificial a l'input original
    inputSecundaries.files = contenidorData.files;
}