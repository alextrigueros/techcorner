<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Comanda - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <div class="contenidor-carret">
        <?php
        //Si la comanda s'ha processat correctament, mostrem el missatge d'èxit, sino mostrem el missatge d'error
        if ($exit) {
            echo "<h1>Compra finalitzada amb èxit!</h1>";
        } else {
            echo "<h1>Ups... hi ha hagut un problema</h1>";
        }
        echo "<p>$missatge</p>";

        echo "<br>";
        echo "<a href='index.php?accio=botiga' class='boto-comprar'>Tornar a la botiga</a>";
        ?>
    </div>
    <?php include "views/footer_view.php"; ?>

</body>

</html>