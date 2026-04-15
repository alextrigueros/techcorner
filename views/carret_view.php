<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Carret - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="assets/images/logos/favicon.png">
</head>

<body>
    <?php include "views/header_view.php"; ?>

    <div class="contenidor seccio-carret">
        <h1 class="titol-carret">El teu carret</h1>

        <div class="contenidor-carret">
            <?php
            // Si no hi ha productes al carret, mostra un missatge indicant que està buit i un botó gran
            if (count($productes_carret) == 0): ?>
                <div class="carret-buit">
                    <p>El teu carret està buit.</p>
                    <a href="index.php?accio=botiga" class="boto-primari-gran">Anar a la botiga</a>
                </div>
            <?php else: ?>
                <div class="accions-globals">
                    <a href="index.php?accio=botiga" class="boto-secundari-carret">← Seguir comprant</a>
                </div>
                
                <div class="layout-carret">

                    <div class="productes-carret">
                        <?php foreach ($productes_carret as $p):
                            $id_detall = $p['detall_carret_id'];
                            $subtotal = number_format($p['preu'] * $p['quantitat'], 2);
                        ?>
                            <div class="targeta-carret-horitzontal">
                                <img src="content/products/<?php echo $p['imatge_url']; ?>" alt="<?php echo $p['nom']; ?>">

                                <div class="info-producte-carret">
                                    <h3><?php echo $p['nom']; ?></h3>
                                    <p class="preu-unitari"><?php echo $p['preu']; ?> € / unitat</p>
                                </div>

                                <div class="quantitat-carret">
                                    <span>Quantitat: <strong><?php echo $p['quantitat']; ?></strong></span>
                                </div>

                                <div class="subtotal-producte">
                                    <span><?php echo $subtotal; ?> €</span>
                                </div>

                                <div class="accions-carret">
                                    <a href="index.php?accio=eliminar_item&id=<?php echo $id_detall; ?>" class="enllac-eliminar">Eliminar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>

                    <aside class="resum-compra">
                        <h2>Resum de la comanda</h2>
                        <div class="linia-resum">
                            <span>Productes (<?php echo count($productes_carret); ?>)</span>
                            <span><?php echo number_format($total_carret, 2); ?> €</span>
                        </div>
                        <div class="linia-resum">
                            <span>Enviament</span>
                            <span class="gratis">Gratis</span>
                        </div>
                        <hr>
                        <div class="total-comanda">
                            <span>Total (IVA inclòs)</span>
                            <span class="import-total"><?php echo number_format($total_carret, 2); ?> €</span>
                        </div>

                        <a href="index.php?accio=finalitzar_comanda" class="boto-finalitzar">
                            Finalitzar Compra
                        </a>
                    </aside>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include "views/footer_view.php"; ?>
    <button id="btnPujar" class="boto-pujar" title="Anar a dalt">↑</button>
    <script src="assets/js/botopujar.js"></script>
</body>

</html>