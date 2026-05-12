document.addEventListener('DOMContentLoaded', () => {
    //Localitzem els elements que necessitem
    let btnObrir = document.getElementById('btn-flotant-xat');
    let finestraXat = document.getElementById('finestra-xat');
    let btnTancar = document.getElementById('btn-tancar-xat');
    let inputXat = document.getElementById('input-xat');
    let btnEnviar = document.getElementById('btn-enviar-xat');
    let contenidorMissatges = document.getElementById('xat-missatges');
    let btnPujarImg = document.getElementById('btn-pujar-imatge');
    let inputImatge = document.getElementById('input-imatge-xat');

    let historialMemoria = [];
    let missatgeIdCounter = 0;

    //Per defecte el xat està tancat, només es veu el botó flotant
    finestraXat.style.display = 'none';
    btnObrir.style.display = 'block';

    //Obrir i tancar el xat
    btnObrir.addEventListener('click', () => {
        finestraXat.style.display = 'flex';
        btnObrir.style.display = 'none';
    });

    btnTancar.addEventListener('click', () => {
        finestraXat.style.display = 'none';
        btnObrir.style.display = 'block';
    });

    //Si seleccionem una imatge deshabilitem l'input de text
    inputImatge.addEventListener('change', () => {
        if (inputImatge.files.length > 0) {
            inputXat.value = "+1 foto";
            inputXat.disabled = true; //Deshabilitem el text
        } else {
            inputXat.value = "";
            inputXat.disabled = false;
        }
    });

    //Enviar missatge amb click o Enter
    btnEnviar.addEventListener('click', enviarMissatge);
    inputXat.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') enviarMissatge();
    });

    btnPujarImg.addEventListener('click', () => inputImatge.click());

    //Funció per enviar missatge al servidor i gestionar la resposta
    async function enviarMissatge() {
        let text = inputXat.value.trim();
        let imatge = inputImatge.files[0];

        //Si no hi ha text ni imatge, no fem res
        if (text === "" && !imatge) return;

        //Deshabilitem els inputs mentre esperem la resposta per evitar múltiples enviaments
        btnEnviar.disabled = true;
        inputXat.disabled = true;
        btnPujarImg.disabled = true;

        //Afegim bafarada d'usuari (si hi ha text o imatge)
        let textBafarada;
        if (imatge) {
            textBafarada = "📷 Imatge: " + imatge.name;
        } else {
            textBafarada = text;
        }
        afegirBafarada(textBafarada, 'usuari');

        inputXat.value = '';
        let idCarrega = afegirBafarada("Pensant...", 'bot');
        let elementPensant = document.getElementById(idCarrega);
        elementPensant.classList.add('animacio-pensant');

        try {
            //Creem FormData per enviar text i imatge al servidor com si fos un formulari
            let formData = new FormData();
            formData.append('missatge', text);
            formData.append('historial', JSON.stringify(historialMemoria));
            if (imatge) formData.append('imatge', imatge);

            //Enviem la petició al servidor i esperem la resposta
            let resposta = await fetch('controllers/chatbot_controller.php', {
                method: 'POST',
                body: formData
            });

            //Convertim la resposta a JSON
            let dades = await resposta.json();
            //Actualitzem el bafarada del bot amb la resposta real i eliminem l'animació de pensant
            elementPensant.innerText = dades.resposta;
            elementPensant.classList.remove('animacio-pensant');

            //Afegim el missatge de l'usuari i la resposta del bot al historial de memòria
            historialMemoria.push({ "role": "user", "content": text });
            historialMemoria.push({ "role": "assistant", "content": dades.resposta });

            //Si superem els 8 elements (4 missatges usuari + 4 respostes bot), eliminem els 2 més antics
            //Per no tenir un historial massa llarg que pugui afectar el rendiment o la coherència de les respostes
            if (historialMemoria.length > 8) {
                historialMemoria.splice(0, 2);
            }

        } catch (error) {
            elementPensant.innerText = "Error de connexió.";
            console.error(error);
        }
        finally {
            //Habilitem tot quan el bot acaba
            btnEnviar.disabled = false;
            inputXat.disabled = false;
            btnPujarImg.disabled = false;
            inputXat.value = "";
            inputImatge.value = ""; //Netegem la imatge
        }
    }

    //Funció per afegir bafarada al xat i retornar l'ID del contenidor creat
    function afegirBafarada(text, qui) {
        let div = document.createElement('div');
        div.classList.add('missatge', qui);
        div.innerText = text;

        //Generem un ID realment únic combinant temps i comptador
        let marcaTemps = Date.now();

        let numeroMissatge = missatgeIdCounter;

        let id = "msg-" + marcaTemps + "-" + numeroMissatge;

        missatgeIdCounter++;

        div.id = id;

        contenidorMissatges.appendChild(div);
        //Desplacem el scroll cap avall per mostrar el nou missatge
        contenidorMissatges.scrollTop = contenidorMissatges.scrollHeight;
        return id;
    }
});