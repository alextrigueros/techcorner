<!DOCTYPE html>
<html lang="ca">

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

            echo "<p><strong>Nom:</strong> $nom_complet</p>";
            echo "<p><strong>Email:</strong> $email</p>";
            ?>
            <a href="index.php?accio=logout">Tancar Sessió</a>
        </div>

        <div class="seccio-perfil">
            <h3>Canviar contrasenya</h3>

            <?php
            if (isset($error_password)) {
                echo "<p class='missatge-error'>$error_password</p>";
            }
            if (isset($msg_password)) {
                echo "<p class='missatge-correcte'>$msg_password</p>";
            }
            ?>

            <form action="index.php?accio=perfil" method="POST">
                <label>Contrasenya actual:</label>
                <div class="contenidor-input-password">
                    <input type="password" id="pass_actual" name="pass_actual" required>
                    <button type="button" class="boto-revelar" onclick="togglePassword('pass_actual', this)">🔒</button>
                </div>

                <label>Nova contrasenya:</label>
                <div class="contenidor-input-password">
                    <input type="password" id="nova_pass" name="nova_pass" required>
                    <button type="button" class="boto-revelar" onclick="togglePassword('nova_pass', this)">🔒</button>
                </div>

                <label>Repeteix la nova contrasenya:</label>
                <div class="contenidor-input-password">
                    <input type="password" id="nova_pass_confirm" name="nova_pass_confirm" required>
                    <button type="button" class="boto-revelar" onclick="togglePassword('nova_pass_confirm', this)">🔒</button>
                </div>

                <button type="submit" name="btn_canviar_pass">Actualitzar contrasenya</button>
            </form>
        </div>

        <form method="POST" class="form-borrar-compte" onsubmit="return confirm('Estas segur que vols esborrar el teu compte? Aquesta acció no es pot desfer')">
            <button type="submit" name="btn_borrar_compte">
                Borrar el meu compte
            </button>
        </form>

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
    <script src="assets/js/contrasenya.js"></script>
</body>

</html>