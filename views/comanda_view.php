<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Comanda - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <main class="contenidor seccio-carret">
        <div class="confirmacio-compra">
            <!-- Si la comanda s'ha processat correctament, mostrem el missatge d'èxit, sino mostrem el missatge d'error -->
            <?php if ($exit): ?>
                <div class="icona-estat exit">✔</div>
                <h1 class="titol-comanda">Compra finalitzada amb èxit!</h1>
            <?php else: ?>
                <div class="icona-estat error">✖</div>
                <h1 class="titol-comanda">Ups... hi ha hagut un problema</h1>
            <?php endif; ?>

            <p class="missatge-confirmacio"><?php echo $missatge; ?></p>

            <div class="accions-confirmacio">
                <a href="index.php?accio=botiga" class="boto-primari-gran">Tornar a la botiga</a>
            </div>
        </div>
    </main>
    <?php include "views/footer_view.php"; ?>

</body>

</html>