<?php
require_once "models/producte.php";

//Recollim els valors dels filtres, si no hi han posem valors buits
if (isset($_GET["cerca"])) {
    $cerca = $_GET["cerca"];
} else {
    $cerca = "";
}

if (isset($_GET["categories"])) {
    $cats_triades = $_GET["categories"];
} else {
    $cats_triades = [];
}

if (isset($_GET["marques"])) {
    $marques_triades = $_GET["marques"];
} else {
    $marques_triades = [];
}

if (isset($_GET["ordre"])) {
    $ordre = $_GET["ordre"];
} else {
    $ordre = "";
}

//Demanem les dades al model de producte
$productes = obtenirProductesFiltrats($conn, $cerca, $cats_triades, $marques_triades, $ordre);
$llista_categories = obtenirCategories($conn);
$llista_marques = obtenirMarquesUniques($conn);

//Carreguem la vista
include "views/botiga_view.php";
