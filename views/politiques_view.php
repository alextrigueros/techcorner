<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Política de Privacitat - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logos/favicon.png">
</head>

<body>
    <?php include "views/header_view.php"; ?>

    <div class="contenidor-info">
        <h1>Polítiques de Privacitat</h1>

        <section>
            <h2>1. Propòsit</h2>
            <p>El lloc web TechCorner és propietat i està gestionat per Alex Trigueros León. La nostra activitat principal és la comercialització de productes electrònics.</p>
        </section>

        <section>
            <h2>2. Dades que recollim</h2>
            <p>Per al correcte funcionament de la botiga, recollim la següent informació:</p>
            <ul>
                <li>Dades de registre: Nom, cognoms i correu electrònic.</li>
                <li>Dades de compra: Productes seleccionats, historial de comandes i adreça d'enviament.</li>
                <li>Seguretat: La teva contrasenya s'emmagatzema xifrada mitjançant algoritmes de hash segurs.</li>
            </ul>
        </section>

        <section>
            <h2>3. Ús de les dades</h2>
            <p>Les teves dades s'utilitzen exclusivament per gestionar el teu carret de la compra, processar les comandes i mantenir la teva sessió activa al sistema.</p>
        </section>

        <section>
            <h2>4. Drets de l'usuari</h2>
            <p>Com a usuari de TechCorner, tens dret a accedir a les teves dades o l'eliminació total del compte de la nostra base de dades.</p>
        </section>

    </div>
    <?php include "views/chatbot_view.php"; ?>
    <?php include "views/footer_view.php"; ?>
    <button id="btnPujar" class="boto-pujar" title="Anar a dalt">↑</button>
    <script src="assets/js/botopujar.js"></script>
</body>

</html>