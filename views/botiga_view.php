<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Botiga - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php include "views/header_view.php"; ?>
    <h1 class="titol-pagina">Catàleg TechCorner</h1>

    <div class="contenidor layout-botiga">
        <div class="filtres">
            <form action="index.php" method="GET">
                <input type="hidden" name="accio" value="botiga">

                <div class="grup-filtre">
                    <h3>Cercador</h3>
                    <!--Mantindrem al cercador el que l'usuari ha introduït amb la variable $cerca-->
                    <input type="text" name="cerca" value="<?php echo $cerca; ?>" placeholder="Busca un producte...">
                </div>

                <div class="grup-filtre">
                    <h3>Categories</h3>
                    <?php
                    //Recorrem les categories disponibles a la BD per mostrar-les com a checkbox
                    foreach ($llista_categories as $cat) {
                        $id = $cat['categoria_id'];
                        $nom = $cat['nom'];

                        $checked = "";
                        //Si la categoria està dins de les categories triades per l'usuari, marquem el checkbox com a checked
                        foreach ($cats_triades as $id_triat) {
                            if ($id == $id_triat) {
                                $checked = "checked";
                                break;
                            }
                        }

                        //Construïm el checkbox, amb el checked si cal, i posem com a name categories[] perquè ens arribi com un array al controller
                        echo "<input type='checkbox' name='categories[]' value='$id' $checked> $nom<br>";
                    }

                    ?>
                </div>

                <div class="grup-filtre">
                    <h3>Marques</h3>
                    <?php
                    //Recorrem les marques disponibles a la BD per mostrar-les com a checkbox
                    foreach ($llista_marques as $m) {
                        $marca = $m['marca'];

                        //Si la marca està dins de les marques triades per l'usuari, marquem el checkbox com a checked
                        $checked = "";
                        foreach ($marques_triades as $marca_triat) {
                            if ($marca == $marca_triat) {
                                $checked = "checked";
                                break;
                            }
                        }
                        //Construïm el checkbox, amb el checked si cal i posem com a name marques[] perquè ens arribi com un array al controller
                        echo "<input type='checkbox' name='marques[]' value='$marca' $checked> $marca <br>";
                    }
                    ?>
                </div>

                <div class="grup-filtre">
                    <h3>Ordenar per</h3>
                    <select name="ordre">
                        <option value="">Per defecte</option>
                        <?php
                        //Si l'usuari ha triat ordenar per preu ascendent, marquem aquesta opció com a selected al desplegable
                        $sel_asc = "";
                        if ($ordre == "preu_asc") {
                            $sel_asc = "selected";
                        }

                        //Si l'usuari ha triat ordenar per preu descendent, marquem aquesta opció com a selected al desplegable
                        $sel_desc = "";
                        if ($ordre == "preu_desc") {
                            $sel_desc = "selected";
                        }
                        //Construïm les opcions de l'ordre, amb el selected si cal
                        echo "<option value='preu_asc' $sel_asc>Preu més baix</option>";
                        echo "<option value='preu_desc' $sel_desc>Preu més alt</option>";
                        ?>
                    </select>
                </div>

                <br>
                <button type="submit">Aplicar Filtres</button>
                <!-- Enllaç per netejar els filtres recarregant la pàgina -->
                <a href="index.php?accio=botiga">Netejar</a>
            </form>
        </div>

        <div class="productes">
            <?php
            if (count($productes) > 0) {
                foreach ($productes as $p) {
                    $id = $p['producte_id'];
                    $imatge = $p['imatge_url'];
                    $nom = $p['nom'];
                    $preu = $p['preu'];
                    $stock = $p['stock'];

                    echo "<div class='targeta'>
                <img src='content/products/$imatge' alt='$nom'>
                <h4>$nom</h4>
                <p class='preu'>$preu €</p>
                
                <div class='botons-targeta'>
                    <a href='index.php?accio=fitxa&id=$id' class='boto-veure'>Veure producte</a>";

                    if ($stock > 0) {
                        //Si hi ha stock, mostrem el botó normal
                        echo "<a href='index.php?accio=afegir_carret&id=$id' class='boto-carret'>Afegir al carret</a>";
                    } else {
                        //Si no hi ha stock, mostrem un botó desactivat
                        echo "<p>Esgotat</p>";
                    }
                    echo "</div>
            </div>";
                }
            } else {
                echo "<p>No s'han trobat productes amb aquests filtres.</p>";
            }
            ?>
        </div>
    </div>
    <?php include "views/footer_view.php"; ?>
</body>

</html>