<?php
require_once "models/comanda.php";

//Comprovem que l'usuari està loguejat sino el redirigim al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?accio=login");
    exit;
}

$usuari_id = $_SESSION['user_id'];

$resultat = finalitzarCompra($conn, $usuari_id);

if ($resultat === true) {
    $missatge = "Gràcies per la teva compra! La comanda s'ha realitzat correctament.";
    $exit = true;
} elseif ($resultat === false) {
    $missatge = "El teu carret està buit o no s'ha pogut processar.";
    $exit = false;
} else {
    //Si no és booleà, vol dir que hem rebut el missatge de "Error: No hi ha prou estoc..."
    $missatge = $resultat;
    $exit = false;
}

//Carreguem la vista. 
include "views/comanda_view.php";
