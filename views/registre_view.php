<!DOCTYPE html>
<html>

<head>
    <title>Registre - TechCorner</title>
</head>

<body>
    <h2>Crear un compte nou</h2>

    <!-- Si hi ha un error, el mostrem -->
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'> $error </p>";
    }
    ?>

    <form action="index.php?accio=registre" method="POST">

        <label>Nom:</label><br>
        <input type="text" name="nom" required><br><br>

        <label>Cognoms:</label><br>
        <input type="text" name="cognoms" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contrasenya:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="btn_registre">Registrar-se</button>
    </form>

    <br>
    <a href="index.php?accio=login">Ja tinc un compte (Inicia sessió)</a>
</body>

</html>