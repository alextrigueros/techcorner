<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Error - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logos/favicon.png">
</head>

<body>
    <?php include "views/header_view.php"; ?>

    <main class="contenidor seccio-carret">
        <div class="caixa-error">
            <h2 class="titol-error">Ups...</h2>
            <p class="missatge-error">Ho sentim, però ha ocorregut un error inesperat.</p>
            <a href="index.php?accio=home" class="boto-primari-gran">Anar a l'inici</a>
        </div>
    </main>

    <?php include "views/footer_view.php"; ?>
    <button id="btnPujar" class="boto-pujar" title="Anar a dalt">🡩</button>
    <script src="assets/js/botopujar.js"></script>

</body>

</html>