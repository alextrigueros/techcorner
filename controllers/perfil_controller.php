<?php
require_once "models/usuari.php";

//Si l'usuari no està loguejat, el redirigim al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?accio=login");
    exit;
}

$usuari_id = $_SESSION['user_id'];

//Demanem les dades al model
$usuari = obtenirDadesUsuari($conn, $usuari_id);
$comandes = obtenirComandesUsuari($conn, $usuari_id);

//Carreguem la vista
include "views/perfil_view.php";
?>