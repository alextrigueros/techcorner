<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Inici - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logos/favicon.png">
</head>

<body>

    <?php include "views/header_view.php"; ?>

    <main class="contenidor principal-home">
        <section class="seccio-hero">
            <h1>Benvingut a TechCorner!</h1>
            <?php
            if (isset($_SESSION['user_nom'])) {
                $nom = $_SESSION['user_nom'];
                echo "<p class='text-destacat'>Hola, <strong>$nom</strong>! Què vols comprar avui?</p>";
            } else {
                echo "<p class='text-destacat'>La teva botiga de tecnologia de confiança. Explora el nostre catàleg!</p>";
            }
            ?>
        </section>

        <section class="seccio-productes">
            <h2>Productes Destacats</h2>
            <div class="graella-productes">
                <?php
                foreach ($productes_destacats as $p) {
                    $id = $p['producte_id'];
                    $nom = $p['nom'];
                    $preu = $p['preu'];
                    $imatge = $p['imatge_url'];

                    echo "<div class='targeta-producte'>
                            <div class='contenidor-imatge'>
                            <img src='content/products/$imatge' alt='$nom' class='imatge-producte'>
                            </div>
                            <h3 class='titol-producte'>$nom</h3>
                            <p class='preu-producte'>$preu €</p>
                            <a href='index.php?accio=fitxa&id=$id' class='boto-primari'>Veure</a>
                          </div>";
                }
                ?>
            </div>
        </section>

        <section class="seccio-categories">
            <h2>Explora per Categoria</h2>
            <ul class="llista-categories">
                <?php
                foreach ($categories as $cat) {
                    $id_cat = $cat['categoria_id'];
                    $nom_cat = $cat['nom'];
                    echo "<li><a href='index.php?accio=botiga&categories[]=$id_cat' class='etiqueta-categoria'>$nom_cat</a></li>";
                }
                ?>
            </ul>
        </section>

        <h2>Per què TechCorner?</h2>
        <section class="seccio-avantatges">
            <ul class="llista-avantatges">
                <li>
                    <div class="tick">✔</div>Enviament en 24h
                </li>
                <li>
                    <div class="tick">✔</div>Garantia oficial de 3 anys
                </li>
                <li>
                    <div class="tick">✔</div>Atenció al client personalitzada
                </li>
                <li>
                    <div class="tick">✔</div>Gran varietat de productes
                </li>
                <li>
                    <div class="tick">✔</div>Experiència dins del sector
                </li>
                <li>
                    <div class="tick">✔</div>Preus competitius
                </li>
                </li>
            </ul>
        </section>

    </main>

    <?php include "views/footer_view.php"; ?>
    <button id="btnPujar" class="boto-pujar" title="Anar a dalt">↑</button>
    <script src="assets/js/botopujar.js"></script>
</body>

</html>