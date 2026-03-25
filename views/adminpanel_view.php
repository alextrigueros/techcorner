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
                            <option value='pendent'>Pendent</option>
                            <option value='pagat'>Pagat</option>
                            <option value='enviat'>Enviat</option>
                            <option value='lliurat'>Lliurat</option>
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


                    <h2>Gestió d'Stock</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Producte</th>
                                <th>Stock Actual</th>
                                <th>Afegir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //Recorrem els productes i mostrem una fila per cada un amb un formulari per afegir stock
                            foreach ($productes as $p) {
                                $id_p = $p['producte_id'];
                                $nom_p = $p['nom'];
                                $stock = $p['stock'];

                                echo "<tr>
                                        <td>$nom_p</td>
                                        <td>$stock</td>
                                        <td>
                                            <form method='POST'>

                                                <!-- Enviem l'id del producte i la quantitat a afegir per actualitzar l'stock -->
                                                
                                                <input type='hidden' name='id_producte' value='$id_p'>
                                                <input type='number' name='quantitat' value='1' style='width:50px;'>
                                                <button type='submit' name='btn_stock'>Afegir Stock</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                            echo "</tbody></table>";

                            include "views/footer_view.php";
                            ?>
</body>

</html>