<?php
session_start();
require_once "config/db.php";

// Mirem que vol fer l'usuari, per defecte anem a la home
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

    case 'afegir_carret':
        //Comprovem si l'usuari està loguejat
        if (!isset($_SESSION['user_id'])) {
            //Si no està loguejat l'enviem al login
            header("Location: index.php?accio=login");
            exit;
        }

        //Si està loguejat, processem el carret
        require_once "models/carret.php";
        $producte_id = $_GET['id'];
        $usuari_id = $_SESSION['user_id'];

        $id_carret = obtenirIdCarret($conn, $usuari_id);
        afegirProducteAlCarret($conn, $id_carret, $producte_id);

        //Un cop afegit, tornem a la botiga
        header("Location: index.php?accio=botiga");
        break;

    case 'carret':
    case 'afegir_carret':
    case 'eliminar_item':
        include "controllers/carret_controller.php";
        break;

    case 'finalitzar_comanda':
        include "controllers/comanda_controller.php";
        break;
        
    case 'home':
        //Mirem si l'usuari s'ha loguejat per utilitzar el seu nom
        if (isset($_SESSION['user_nom'])) {
            $nom_a_mostrar = $_SESSION['user_nom'];
        }
        //Sino li direm convidat
        else {
            $nom_a_mostrar = "Convidat";
        }

        echo "<h1>Benvingut a TechCorner, $nom_a_mostrar</h1>";

        echo "<a href='index.php?accio=login'>Anar al Login</a>";
        echo "<br>";
        echo "<a href='index.php?accio=registre'>Registrar-se</a>";
        echo "<br>";
        echo "<a href='index.php?accio=botiga'>Anar a la Botiga</a>";
        break;

    default:
        echo "Pàgina no trobada";
        break;
}
