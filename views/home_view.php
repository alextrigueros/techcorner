<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Inici - TechCorner</title>
</head>

<body>

    <?php include "views/header_view.php"; ?>

    <section>
        <h1>Benvingut a TechCorner</h1>
        <?php
        // Missatge de benvinguda personalitzat si l'usuari està loguejat
        if (isset($_SESSION['user_nom'])) {
            $nom = $_SESSION['user_nom'];
            echo "<p>Hola, $nom! Què vols comprar avui?</p>";
        } else {
            echo "<p>La teva botiga de tecnologia de confiança. Explora el nostre catàleg!</p>";
        }
        ?>
    </section>

    <section>
        <h2>Productes Destacats</h2>
        <div style="display: flex; gap: 20px; flex-wrap: wrap;">
            <?php
            //Bucle per als productes aleatoris
            foreach ($productes_destacats as $p) {
                $id = $p['producte_id'];
                $nom = $p['nom'];
                $preu = $p['preu'];
                $imatge = $p['imatge_url'];

                echo "<div>
                        <img src='content/products/$imatge' alt='$nom'>
                        <h3>$nom</h3>
                        <p>Preu: $preu €</p>
                        <a href='index.php?accio=fitxa&id=$id'>Veure detall</a>
                      </div>";
            }
            ?>
        </div>
    </section>

    <section>
        <h2>Explora per Categoria</h2>
        <ul>
            <?php
            //Llista de categories per navegació ràpida
            foreach ($categories as $cat) {
                $id_cat = $cat['categoria_id'];
                $nom_cat = $cat['nom'];

                echo "<li>
                        <a href='index.php?accio=botiga&categories[]=$id_cat'>$nom_cat</a>
                      </li>";
            }
            ?>
        </ul>
    </section>

    <section>
        <h2>Per què comprar a TechCorner?</h2>
        <ul>
            <li>Enviament en 24h</li>
            <li>Garantia oficial de 3 anys</li>
            <li>Atenció al client personalitzada</li>
        </ul>
    </section>

    <?php include "views/footer_view.php"; ?>

</body>

</html>