<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Comanda - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="contenidor-carret">
        <?php
        //Si la compra ha sigut exitosa, mostrem un missatge de confirmació, sinó un missatge d'error
        if ($compra_exitosa) {
            echo "<h1>Compra finalitzada amb èxit!</h1>";
            echo "<p>Gràcies per la teva comanda a TechCorner. Hem buidat el teu carret de la compra.</p>";
        } else {
            echo "<h1>Ups...</h1>";
            echo "<p>Sembla que no hi havia res al teu carret per poder finalitzar la comanda.</p>";
        }

        echo "<br>";
        echo "<a href='index.php?accio=botiga' class='boto-comprar'>Tornar a la botiga</a>";
        ?>
    </div>
</body>

</html>