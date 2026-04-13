<!DOCTYPE html>
<html lang="ca">
<html>

<head>
    <meta charset="UTF-8">
    <title>Login - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <div class="contenidor">
        <div class="caixa-formulari">
            <h2>Inici de sessió</h2>

            <!-- Si hi ha un error, el mostrem -->
            <?php
            if (isset($error)) {
                echo "<p class='missatge-error'> $error </p>";
            }
            ?>

            <form action="index.php?accio=login" method="POST" class="formulari-registre">
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

                <button type="submit" name="btn_login" class="boto-primari-gran">Entrar</button>
            </form>

            <p class="text-peu-formulari">No tens un compte? <a href="index.php?accio=registre">Registra't</a></p>
        </div>
    </div>

    <?php include "views/footer_view.php"; ?>
    <script src="assets/js/registre.js"></script>

</body>

</html>