<script src="assets/js/chatbot.js"></script>

<div class="chatbot-contenidor">
    <div id="finestra-xat" class="finestra-xat">
        <div class="xat-capcalera">
            <h4>TechCorner Assistant</h4>
            <button id="btn-tancar-xat" class="btn-tancar">
                <img src="assets/images/icons/x.png" alt="Tancar">
            </button>
        </div>
        <div id="xat-missatges" class="xat-missatges">
            <div class="missatge bot">Hola! Sóc l'assistent IA de TechCorner. Què busques avui?</div>
        </div>
        <div class="xat-inputs">
            <input type="file" id="input-imatge-xat" accept="image/*">
            <button id="btn-pujar-imatge" class="boto-pujar-imatge">📷</button>
            <input type="text" id="input-xat" placeholder="Escriu o puja una imatge...">
            <button id="btn-enviar-xat" class="boto-enviar-xat">➤</button>
        </div>
    </div>

    <button id="btn-flotant-xat" class="btn-flotant-xat">
        <img src="assets/images/icons/chatbot.png" alt="Xat">
    </button>
</div>