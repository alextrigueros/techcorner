<?php
require_once "models/producte.php";

//Iniciem la sessió per poder guardar dades entre pàgines
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Gestionar la neteja de filtres
if (isset($_GET['reset'])) {
    unset($_SESSION['filtres']);
    header("Location: index.php?accio=botiga");
    exit;
}

//Si hi ha dades noves al $_GET, les guardem a la sessió
if (isset($_GET['cerca']) || isset($_GET['categories']) || isset($_GET['marques']) || isset($_GET['ordre'])) {

    //Creem un array temporal per organitzar la sessió
    $dades_a_guardar = array();

    if (isset($_GET['cerca'])) {
        $dades_a_guardar['cerca'] = $_GET['cerca'];
    } else {
        $dades_a_guardar['cerca'] = "";
    }

    if (isset($_GET['categories'])) {
        $dades_a_guardar['categories'] = $_GET['categories'];
    } else {
        $dades_a_guardar['categories'] = array();
    }

    if (isset($_GET['marques'])) {
        $dades_a_guardar['marques'] = $_GET['marques'];
    } else {
        $dades_a_guardar['marques'] = array();
    }

    if (isset($_GET['ordre'])) {
        $dades_a_guardar['ordre'] = $_GET['ordre'];
    } else {
        $dades_a_guardar['ordre'] = "";
    }

    $_SESSION['filtres'] = $dades_a_guardar;
}

//Recuperar dades de la sessió
if (isset($_SESSION['filtres']['cerca'])) {
    $cerca = $_SESSION['filtres']['cerca'];
} else {
    $cerca = "";
}

if (isset($_SESSION['filtres']['categories'])) {
    $cats_triades = $_SESSION['filtres']['categories'];
} else {
    $cats_triades = array();
}

if (isset($_SESSION['filtres']['marques'])) {
    $marques_triades = $_SESSION['filtres']['marques'];
} else {
    $marques_triades = array();
}

if (isset($_SESSION['filtres']['ordre'])) {
    $ordre = $_SESSION['filtres']['ordre'];
} else {
    $ordre = "";
}

//Demanem les dades al model amb els valors recuperats
$productes = obtenirProductesFiltrats($conn, $cerca, $cats_triades, $marques_triades, $ordre);
$llista_categories = obtenirCategories($conn);
$llista_marques = obtenirMarquesUniques($conn);

//Carreguem la vista
include "views/botiga_view.php";
