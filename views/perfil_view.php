<!DOCTYPE html>
<html lang="ca">
<html>

<head>
    <meta charset="UTF-8">
    <title>Perfil - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>

    <div class="contenidor-perfil">
        <h1>El meu perfil</h1>

        <div class="dades-usuari">
            <h3>Dades personals</h3>
            <?php

            $nom_complet = $usuari['nom'] . " " . $usuari['cognoms'];
            $email = $usuari['email'];

            echo "<p>Nom:</strong> $nom_complet</p>";
            echo "<p>Email:</strong> $email</p>";
            ?>
            <br>
            <a href="index.php?accio=logout">Tancar Sessió</a>
        </div>

        <div class="historial-comandes">
            <h3>El meu historial de comandes</h3>

            <?php
            if (count($comandes) === 0) {
                echo "<p>Encara no has fet cap comanda a TechCorner.</p>";
            } else {
                echo "<table>
                    <thead>
                        <tr>
                            <th>Nº de comanda</th>
                            <th>Data</th>
                            <th>Total</th>
                            <th>Estat</th>
                        </tr>
                    </thead>
                    <tbody>";

                foreach ($comandes as $c) {
                    $id_comanda = $c['comanda_id'];
                    $data = $c['data_comanda'];
                    $total = $c['total'];
                    $estat = ucfirst($c['estat']);

                    echo "<tr>
                        <td>#$id_comanda</td>
                        <td>$data</td>
                        <td>$total €</td>
                        <td>$estat</td>
                    </tr>";
                }

                echo "</tbody>
                </table>";
            }
            ?>
        </div>
    </div>
    <?php include "views/footer_view.php"; ?>
</body>

</html>