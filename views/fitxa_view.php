<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title><?php echo $p['nom']; ?> - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <div class="contenidor-fitxa">
        <a href="index.php?accio=botiga">Tornar a la botiga</a>

        <div class="producte-gran">
            <div class="imatge-gran">
                <img src="content/products/<?php echo $p['imatge_url']; ?>">
            </div>

            <div class="info-detall">
                <h1><?php echo $p['nom']; ?></h1>
                <p>Marca: <?php echo $p['marca']; ?></p>
                <p class="descripcio">Descripció: <?php echo $p['descripcio']; ?></p>
                <h2 class="preu"><?php echo $p['preu']; ?> €</h2>
                <p>Stock disponible: <?php echo $p['stock']; ?> unitats</p>

                <br>
                <?php
                if ($p['stock'] > 0) {
                        //Si hi ha stock, mostrem el botó normal
                        echo "<a href='index.php?accio=afegir_carret&id=" . $p['producte_id'] . "' class='boto-carret'>Afegir al carret</a>";
                    } else {
                        //Si no hi ha stock, mostrem un botó desactivat
                        echo "<p>Esgotat</p>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>

</html>