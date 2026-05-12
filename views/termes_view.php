<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Termes i Condicions - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logos/favicon.png">
</head>

<body>
    <?php include "views/header_view.php"; ?>

    <div class="contenidor-info">
        <h1>Termes i Condicions d'ús</h1>
        <p>Benvingut a TechCorner. L'ús d'aquesta plataforma implica l'acceptació d'aquests termes.</p>

        <section>
            <h2>1. Condicions de Venda</h2>
            <p>Tots els productes mostrats a la botiga estan subjectes a disponibilitat de stock. Els preus indicats inclouen l'IVA (21%) i són vàlids excepte error tipogràfic.</p>
        </section>

        <section>
            <h2>2. Enviaments i Logística</h2>
            <p>TechCorner es compromet a processar les comandes de components i perifèrics en un termini de 24h. El temps de lliurament dependrà de l'empresa de transport, tot i que normalment és de 48/72 hores laborables.</p>
        </section>

        <section>
            <h2>3. Garantia de Producte</h2>
            <p>D'acord amb la normativa vigent, tots els components electrònics nous gaudeixen d'una garantia de 3 anys. La garantia cobreix defectes de fabricació, però no danys derivats d'un mal muntatge o manipulació indeguda per part de l'usuari.</p>
        </section>

        <section>
            <h2>4. Política de Devolucions</h2>
            <p>Si no estàs satisfet amb la teva compra, tens un termini de 30 dies per retornar el producte. El producte ha d'estar en el seu embalatge original i sense signes d'ús per poder rebre el reemborsament complet.</p>
        </section>

        <section>
            <h2>5. Propietat Intel·lectual</h2>
            <p>El contingut d'aquesta web, incloent logotips, disseny i codi font, és propietat de TechCorner.</p>
        </section>

    </div>
    <?php include "views/chatbot_view.php"; ?>
    <?php include "views/footer_view.php"; ?>
    <button id="btnPujar" class="boto-pujar" title="Anar a dalt">↑</button>
    <script src="assets/js/botopujar.js"></script>
</body>

</html>