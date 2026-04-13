<header class="capcalera-principal">
    <div class="contenidor capcalera-contingut">
        <div class="logo">
            <a href="index.php?accio=home">
                <img src="assets/images/logos/techcorner_logo4.png" alt="Logo TechCorner" class="imatge-logo">
            </a>
        </div>

        <nav>
            <ul class="llista-nav">

                <li><a href="index.php?accio=botiga">Botiga</a></li>
                <?php
                // Si l'usuari és admin, mostrar enllaç al panell d'administració
                if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin') {
                    echo "<li><a href='index.php?accio=admin'>Panell d'administració</a></li>";
                }
                ?>

                <?php
                if (isset($_SESSION['user_id'])) {
                    echo "<li><a href='index.php?accio=perfil'>Compte</a></li>";
                    echo "<li><a href='index.php?accio=carret' class='carret-icona'>Carret</a></li>";
                }
                ?>

                <?php
                // Si l'usuari no esta identificat, mostrar enllaç per iniciar sessió o registrar-se
                if (!isset($_SESSION['user_id'])) {
                    echo "<li><a href='index.php?accio=login'>Iniciar sessió</a></li>";
                    echo "<li><a href='index.php?accio=registre'>Registrar-se</a></li>";
                }

                ?>
            </ul>
        </nav>
    </div>
</header>