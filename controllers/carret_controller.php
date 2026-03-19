<?php
require_once "models/carret.php";

// Comprovem si l'usuari està loguejat sino el redirigim al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?accio=login");
    exit;
}

$usuari_id = $_SESSION['user_id'];

if (isset($_GET['accio'])) {
    $accio_especifica = $_GET['accio'];
} else {
    $accio_especifica = 'carret';
}

//Afegir producte al carret
if ($accio_especifica == 'afegir_carret') {
    $producte_id = $_GET['id'];
    $carret_id = obtenirIdCarret($conn, $usuari_id);
    afegirProducteAlCarret($conn, $carret_id, $producte_id);
    header("Location: index.php?accio=botiga");
    exit;
}

//Eliminar productes
if ($accio_especifica == 'eliminar_item') {
    $detall_id = $_GET['id'];
    // Aquí cridaries una funció de model per eliminar la fila de DETALL_CARRETS
    $sql_delete = "DELETE FROM DETALL_CARRETS WHERE detall_carret_id = $detall_id";
    mysqli_query($conn, $sql_delete);
    header("Location: index.php?accio=carret");
    exit;
}

//Obtenir els productes del carret per mostrar-los a la vista
$productes_carret = obtenirProductesCarret($conn, $usuari_id); //

//Calculem el total del carret sumant el preu de cada producte multiplicat per la seva quantitat
$total_carret = 0;
foreach ($productes_carret as $p) {
    $total_carret += $p['preu'] * $p['quantitat'];
}

include "views/carret_view.php";
