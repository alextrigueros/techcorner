<?php
require_once "models/producte.php";

//Mirem si ens han passat un ID de producte per mostrar la seva fitxa, sinó tornarem a la botiga
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $p = obtenirProductePerId($conn, $id);

    if (!$p) {
        die("Producte no trobat.");
    }

    include "views/fitxa_view.php";
} else {
    header("Location: index.php?accio=botiga");
}
?>