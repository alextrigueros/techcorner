<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Carret - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <h1>El teu carret</h1>

    <div class="contenidor-carret">
        <?php
        // Si no hi ha productes mostrem el missatge de carret buit
        if (count($productes_carret) == 0) {
            echo "<p>El teu carret està buit. <a href='index.php?accio=botiga'>Vols anar a la botiga?</a></p>";
        } else {
            //Si hi ha, pintem la taula i el resum
            echo "<table>
                <thead>
                    <tr>
                        <th>Producte</th>
                        <th>Preu Unitari</th>
                        <th>Quantitat</th>
                        <th>Subtotal</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>";

            foreach ($productes_carret as $p) {
                $id_detall = $p['detall_carret_id'];
                $nom = $p['nom'];
                $preu = $p['preu'];
                $quantitat = $p['quantitat'];
                $imatge = $p['imatge_url'];
                //Formatem el subtotal a 2 decimals
                $subtotal = number_format($preu * $quantitat, 2);

                echo "<tr>
                    <td>
                        <img src='content/products/$imatge' width='50' style='vertical-align:middle; margin-right:10px;'>
                        $nom
                    </td>
                    <td>$preu €</td>
                    <td>$quantitat</td>
                    <td>$subtotal €</td>
                    <td>
                        <a href='index.php?accio=eliminar_item&id=$id_detall' style='color:red;'>Eliminar</a>
                    </td>
                </tr>";
            }

            echo "</tbody>
            </table>";

            $total_f = number_format($total_carret, 2);

            echo "<div class='resum-carret'>
                <h3>Total: $total_f €</h3>
                <a href='index.php?accio=finalitzar_comanda' class='boto-comprar'>Finalitzar Compra</a>
            </div>";
        }
        ?>

        <br>
        <a href="index.php?accio=botiga">Seguir comprant</a>
    </div>
</body>

</html>