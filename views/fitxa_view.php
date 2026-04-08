<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title><?php echo $p['nom']; ?> - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <div class="contenidor">
        <div class="enllac-tornar">
            <a href="index.php?accio=botiga">← Tornar a la botiga</a>
        </div>

        <div class="layout-fitxa">
            <div class="columna-miniatures">
                <?php if (!empty($imatges_galeria)): ?>
                    <?php foreach ($imatges_galeria as $img): ?>
                        <img src="content/products/<?php echo $img; ?>"
                            class="miniatura"
                            onclick="canviarImatge('content/products/<?php echo $img; ?>')">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="columna-principal">
                <div class="contenidor-imatge-gran">
                    <img id="imatge-principal" src="content/products/<?php echo $p['imatge_url']; ?>" alt="<?php echo $p['nom']; ?>">
                </div>
            </div>

            <div class="columna-compra">
                <p class="marca-text"><?php echo $p['marca']; ?></p>
                <h1 class="titol-producte-fitxa"><?php echo $p['nom']; ?></h1>

                <div class="caixa-preu">
                    <span class="preu-gran"><?php echo $p['preu']; ?> €</span>
                    <p class="iva-text">IVA inclòs</p>
                </div>

                <div class="estat-stock">
                    <?php if ($p['stock'] > 0): ?>
                        <span class="stock en-stock">En stock (<?php echo $p['stock']; ?> unitats)</span>
                    <?php else: ?>
                        <span class="stock sense-stock">Esgotat</span>
                    <?php endif; ?>
                </div>

                <div class="accions-compra">
                    <?php if ($p['stock'] > 0): ?>
                        <a href="index.php?accio=afegir_carret&id=<?php echo $p['producte_id']; ?>" class="boto-carret-gran">
                            Afegir al carret
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="fitxa-descripcio">
            <h2>Descripció del producte</h2>
            <p><?php echo $p['descripcio']; ?></p>
        </div>
    </div>
    <?php include "views/footer_view.php"; ?>
    <script src="assets/js/fitxa.js"></script>
</body>

</html>