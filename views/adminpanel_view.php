<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <title>Panell d'administració - TechCorner</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

    <?php include "views/header_view.php"; ?>

    <h1>Panell d'Administració</h1>

    <h2>Gestió de Comandes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Data</th>
                <th>Total</th>
                <th>Estat</th>
                <th>Acció</th>
            </tr>
        </thead>
        <tbody>

            <?php
            //Recorrem les comandes i mostrem una fila per cada una amb un formulari per canviar l'estat
            foreach ($comandes as $c) {
                $id = $c['comanda_id'];
                $nom_complet = $c['nom'] . " " . $c['cognoms'];
                $data = $c['data_comanda'];
                $total = $c['total'];
                $estat = ucfirst($c['estat']);

                //Segons l'estat de la comanda, marquem l'opció corresponent del select com a seleccionada
                if ($estat == 'Pendent') {
                    $selected_pendent = 'selected';
                    $selected_pagat = '';
                    $selected_enviat = '';
                    $selected_lliurat = '';
                } elseif ($estat == 'Pagat') {
                    $selected_pendent = '';
                    $selected_pagat = 'selected';
                    $selected_enviat = '';
                    $selected_lliurat = '';
                } elseif ($estat == 'Enviat') {
                    $selected_pendent = '';
                    $selected_pagat = '';
                    $selected_enviat = 'selected';
                    $selected_lliurat = '';
                } elseif ($estat == 'Lliurat') {
                    $selected_pendent = '';
                    $selected_pagat = '';
                    $selected_enviat = '';
                    $selected_lliurat = 'selected';
                }

                echo "<tr>
                <td>#$id</td>
                <td>$nom_complet</td>
                <td>$data</td>
                <td>$total €</td>
                <td><strong>$estat</strong></td>
                <td>
                    <form method='POST'>

                    <!-- Enviem l'id de la comanda i el nou estat per actualitzar-lo -->

                        <input type='hidden' name='id_comanda' value='$id'>
                        <select name='nou_estat'>
                            <option value='pendent' $selected_pendent>Pendent</option>
                            <option value='pagat' $selected_pagat>Pagat</option>
                            <option value='enviat' $selected_enviat>Enviat</option>
                            <option value='lliurat' $selected_lliurat>Lliurat</option>
                        </select>
                        <button type='submit' name='btn_estat'>Actualitzar</button>
                    </form>
                </td>
            </tr>";
            }
            echo "</tbody></table>";
            ?>

            <h2>Gestió d'Usuaris</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    //Recorrem els usuaris i mostrem una fila per cada un amb un formulari per canviar el rol o eliminar l'usuari
                    foreach ($usuaris as $u) {
                        $id_u = $u['usuari_id'];
                        $nom = $u['nom'];
                        $email = $u['email'];
                        $rol = $u['rol'];

                        if ($rol == 'usuari') {
                            $selected_usuari = 'selected';
                            $selected_admin = '';
                        } elseif ($rol == 'admin') {
                            $selected_usuari = '';
                            $selected_admin = 'selected';
                        }

                        echo "<tr>
                <td>$nom</td>
                <td>$email</td>
                <td>$rol</td>
                <td>
                    <form method='POST' style='display:inline;'>

                    <!-- Enviem l'id de l'usuari i el nou rol per actualitzar-lo o eliminar l'usuari -->

                        <input type='hidden' name='id_usuari' value='$id_u'>
                        <select name='nou_rol'>
                            <option value='usuari' $selected_usuari>Usuari</option>
                            <option value='admin' $selected_admin>Admin</option>
                        </select>
                        <button type='submit' name='btn_rol'>Canviar Rol</button>
                        <button type='submit' name='btn_eliminar_usuari'>Borrar</button>
                    </form>
                </td>
            </tr>";
                    }
                    echo "</tbody></table>";
                    ?>

                    <h2>Categories Existents</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Acció</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($categories_disponibles as $cat) {
                                $id_c = $cat['categoria_id'];
                                $nom_c = $cat['nom'];

                                echo "<tr>
                                <td>$id_c</td>
                                <td>$nom_c</td>
                                <td>";
                                //Evitem mostrar el botó de borrar per la categoria "Sense Categoria"
                                if ($id_c != 1) {
                                    echo "<form method='POST'>
                                            <input type='hidden' name='id_categoria' value='$id_c'>
                                            <button type='submit' name='btn_eliminar_categoria'>Borrar Categoria</button>
                                        </form>";
                                } else {
                                    echo "<span>Protegida</span>";
                                }

                                echo "</td> </tr>";
                            }
                            echo "</tbody></table>";
                            ?>

                            <h2>Crear Nova Categoria</h2>
                            <form method='POST'>
                                <label>Nom de la Categoria:</label><br>
                                <input type='text' name='nom_cat' required><br><br>
                                <label>Descripció:</label><br>
                                <textarea name='desc_cat' required></textarea><br><br>
                                <button type='submit' name='btn_afegir_categoria'>Afegir Categoria</button>
                            </form>

                            <h2>Afegir Nou Producte</h2>
                            <!-- Posem enctype='multipart/form-data' per a poder enviar arxius (imatges)-->
                            <form method='POST' enctype='multipart/form-data'>
                                <label>Nom del producte:</label><br>
                                <input type='text' name='nom' required><br><br>

                                <label>Marca:</label><br>
                                <input type='text' name='marca' required><br><br>

                                <label>Descripció:</label><br>
                                <textarea name='descripcio' required></textarea><br><br>

                                <label>Preu:</label><br>
                                <input type='number' step='0.01' name='preu' required><br><br>

                                <label>Stock inicial:</label><br>
                                <input type='number' name='stock' required><br><br>

                                <label>Categoria:</label><br>
                                <select name='categoria' required>";
                                    <?php
                                    foreach ($categories_disponibles as $cat) {
                                        $c_id = $cat['categoria_id'];
                                        $c_nom = $cat['nom'];
                                        echo "<option value='$c_id'>$c_nom</option>";
                                    }

                                    echo ' </select><br><br>';
                                    ?>
                                    <label>Imatge Principal:</label><br>
                                    <!--Posem accept='image/*' per a només permetre arxius de tipus imatge-->
                                    <input type='file' name='imatge_principal' accept='image/*' required><br><br>

                                    <label>Imatges Secundàries:</label><br>
                                    <!--Passem les imatges com array fent us de l'atribut name='imatges_secundaries[]' i multiple-->
                                    <input type='file' name='imatges_secundaries[]' accept='image/*' multiple><br><br>

                                    <button type='submit' name='btn_afegir_producte'>Afegir Producte</button>
                            </form>
                            <h2>Gestió de productes</h2>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producte</th>
                                        <th>Stock Actual</th>
                                        <th>Accions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //Recorrem els productes i mostrem una fila per cada un amb un formulari per afegir stock
                                    foreach ($productes as $p) {
                                        $id_p = $p['producte_id'];
                                        $nom_p = $p['nom'];
                                        $stock = $p['stock'];
                                        $cat_actual = $p['categoria_id'];

                                        echo "<tr>
                                        <td>$nom_p</td>
                                        <td>$stock</td>
                                        <td>
                                            <form method='POST'>

                                                <!-- Enviem l'id del producte i la quantitat a afegir per actualitzar l'stock -->
                                                
                                                <input type='hidden' name='id_producte' value='$id_p'>
                                                <select name='nova_categoria'>";

                                        foreach ($categories_disponibles as $cat) {
                                            $c_id = $cat['categoria_id'];
                                            $c_nom = $cat['nom'];
                                            if ($c_id == $cat_actual) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='$c_id' $selected>$c_nom</option>";
                                        }
                                        echo "</select>
                                            <button type='submit' name='btn_canviar_categoria'>Moure</button>
                                            <input type='number' name='quantitat' value='1' style='width:50px;'>
                                            <button type='submit' name='btn_stock'>Afegir Stock</button>
                                            <button type='submit' name='btn_eliminar_producte'>Borrar Producte</button>
                                            </form>
                                        </td>
                                    </tr>";
                                    }
                                    echo "</tbody></table>";
                                    ?>
                                    <?php include "views/footer_view.php"; ?>

</body>

</html>