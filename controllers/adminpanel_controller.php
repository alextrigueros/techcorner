<?php
require_once "models/usuari.php";
require_once "models/comanda.php";
require_once "models/producte.php";

//Només deixem entrar si l'usuari és admin, sino el redirigim a la home
if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Canviar estat comanda
if (isset($_POST['btn_estat'])) {
    actualitzarEstatComanda($conn, $_POST['id_comanda'], $_POST['nou_estat']);
}

// Canviar rol usuari
if (isset($_POST['btn_rol'])) {
    actualitzarRolUsuari($conn, $_POST['id_usuari'], $_POST['nou_rol']);
}

// Eliminar usuari
if (isset($_POST['btn_eliminar_usuari'])) {
    eliminarUsuari($conn, $_POST['id_usuari']);
}

// Modificar stock
if (isset($_POST['btn_stock'])) {
    modificarStock($conn, $_POST['id_producte'], $_POST['quantitat']);
}

$usuaris = obtenirTotsUsuaris($conn);
$comandes = obtenirTotesLesComandesActives($conn);
//Utilitzem la mateixa funció que a la botiga però sense filtres per obtenir tots els productes
$productes = obtenirProductesFiltrats($conn, "", [], [], "");

include "views/adminpanel_view.php";