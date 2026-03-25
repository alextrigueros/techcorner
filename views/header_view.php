    <header>
        <div class="logo">
            <a href="index.php?accio=home">
                TechCorner
            </a>
        </div>

        <nav class="menu-principal">
            <ul>
                <li><a href="index.php?accio=botiga">Botiga</a></li>
                <li><a href="index.php?accio=perfil">👤 Usuari</a></li>
                <?php
                // Si l'usuari és admin, mostrem el link al panell d'administració
                if (isset($_SESSION['user_rol']) && $_SESSION['user_rol'] === 'admin') {
                    echo "<li><a href='index.php?accio=admin'> Panell d'administració</a></li>";
                }
                ?>
                <li><a href="index.php?accio=carret">🛒 Carret</a></li>
            </ul>
        </nav>
    </header>