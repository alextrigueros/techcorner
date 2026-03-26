<?php
session_start();
require_once "config/db.php";

//Mirem que vol fer l'usuari, per defecte anem a la home
if (isset($_GET['accio'])) {
    $accio = $_GET['accio'];
} else {
    $accio = 'home';
}

switch ($accio) {
    case 'login':
        include "controllers/login_controller.php";
        break;

    case 'registre':
        include "controllers/registre_controller.php";
        break;

    case 'botiga':
        include "controllers/botiga_controller.php";
        break;

    case 'carret':
    case 'afegir_carret':
    case 'eliminar_item':
        include "controllers/carret_controller.php";
        break;

    case 'finalitzar_comanda':
        include "controllers/comanda_controller.php";
        break;

    case 'fitxa':
        include "controllers/fitxa_controller.php";
        break;

    case 'perfil':
        include "controllers/perfil_controller.php";
        break;

    case 'logout':
        include "controllers/logout_controller.php";
        break;

    case 'admin':
        include "controllers/adminpanel_controller.php";
        break;

    case 'home':
        include "controllers/home_controller.php";
        break;

    default:
        include "views/error_view.php";
        break;
}
