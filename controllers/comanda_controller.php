<?php
require_once "models/comanda.php";

//Comprovem que l'usuari està loguejat, sinó el redirigim al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?accio=login");
    exit;
}

$usuari_id = $_SESSION['user_id'];

//Fem servir la funció de finalitzar compra, que crearà la comanda a la base de dades i buidarà el carret
$compra_exitosa = finalitzarCompra($conn, $usuari_id);

//Carreguem la vista
include "views/comanda_view.php";
?>