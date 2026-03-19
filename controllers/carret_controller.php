<?php
require_once "models/carret.php";

// Comprovem que l'usuari està loguejat, sinó el redirigim al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?accio=login");
    exit;
}

$usuari_id = $_SESSION['user_id'];
if (isset($_GET['accio'])) {
    $accio = $_GET['accio'];
} else {
    $accio = 'carret';
}

//Afegir producte al carret
if ($accio == 'afegir_carret') {
    if (isset($_GET['id'])) {
        $producte_id = $_GET['id'];
        $carret_id = obtenirIdCarret($conn, $usuari_id);
        afegirProducteAlCarret($conn, $carret_id, $producte_id);
    }
    //Un cop afegit tornem a la botiga
    header("Location: index.php?accio=botiga");
    exit;
}
//Eliminar un item del carret
elseif ($accio == 'eliminar_item') {
    if (isset($_GET['id'])) {
        $detall_id = $_GET['id'];
        //Eliminem el detall del carret que coincideixi amb l'ID rebut
        $sql_delete = "DELETE FROM DETALL_CARRETS WHERE detall_carret_id = $detall_id";
        mysqli_query($conn, $sql_delete);
    }
    //Un cop eliminat refresquem el carret
    header("Location: index.php?accio=carret");
    exit;
}

//Obtenim els productes que hi ha al carret de l'usuari per mostrar-los a la vista

$productes_carret = obtenirProductesCarret($conn, $usuari_id);

// Calculem el total del carret sumant el preu de cada producte multiplicat per la seva quantitat
$total_carret = 0;
foreach ($productes_carret as $p) {
    $total_carret += $p['preu'] * $p['quantitat'];
}

include "views/carret_view.php";
