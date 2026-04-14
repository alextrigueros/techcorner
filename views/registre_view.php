<!DOCTYPE html>
<html lang="ca">
<html>

<head>
    <meta charset="UTF-8">
    <title>Registre - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <div class="contenidor">
        <div class="caixa-formulari">
            <h2>Crear compte</h2>

            <!-- Si hi ha un error, el mostrem -->
            <?php
            if (isset($error)) {
                echo "<p class='missatge-error'> $error </p>";
            }
            ?>

            <form action="index.php?accio=registre" method="POST" class="formulari-registre">
                <div class="grup-formulari">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="grup-formulari">
                    <label for="cognoms">Cognoms:</label>
                    <input type="text" id="cognoms" name="cognoms" required>
                </div>

                <div class="grup-formulari">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="grup-formulari">
                    <label for="password">Contrasenya:</label>
                    <div class="contenidor-input-password">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="boto-revelar" onclick="togglePassword('password', this)">🔒</button>
                    </div>
                </div>

                <div class="grup-formulari">
                    <label for="password_confirm">Repeteix la contrasenya:</label>
                    <div class="contenidor-input-password">
                        <input type="password" id="password_confirm" name="password_confirm" required>
                        <button type="button" class="boto-revelar" onclick="togglePassword('password_confirm', this)">🔒</button>
                    </div>
                </div>

                <button type="submit" name="btn_registre" class="boto-primari-gran">Registrar-se</button>
            </form>

            <p class="text-peu-formulari">Ja tens un compte? <a href="index.php?accio=login">Inicia sessió</a></p>
        </div>
    </div>

    <?php include "views/footer_view.php"; ?>
    <script src="assets/js/contrasenya.js"></script>

</body>

</html>