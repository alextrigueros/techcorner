<!DOCTYPE html>
<html>

<head>
    <title>Login - TechCorner</title>
</head>

<body>
    <h2>Inici de sessió</h2>
    <!-- Si hi ha un error, el mostrem -->
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form action="index.php?accio=login" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contrasenya:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="btn_login">Entrar</button>
    </form>
</body>

</html>