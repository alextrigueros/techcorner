<?php
require_once "models/usuari.php";
require_once "models/comanda.php";
require_once "models/producte.php";

//Només deixem entrar si l'usuari és admin, sino el redirigim a la home
if (!isset($_SESSION['user_rol']) || $_SESSION['user_rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

//Canviar estat comanda
if (isset($_POST['btn_estat'])) {
    actualitzarEstatComanda($conn, $_POST['id_comanda'], $_POST['nou_estat']);
}

//Canviar rol usuari
if (isset($_POST['btn_rol'])) {
    actualitzarRolUsuari($conn, $_POST['id_usuari'], $_POST['nou_rol']);
}

//Eliminar usuari
if (isset($_POST['btn_eliminar_usuari'])) {
    eliminarUsuari($conn, $_POST['id_usuari']);
}

//Modificar stock
if (isset($_POST['btn_stock'])) {
    modificarStock($conn, $_POST['id_producte'], $_POST['quantitat']);
}

//Canviar categoria de producte
if (isset($_POST['btn_canviar_categoria'])) {
    actualitzarCategoriaProducte($conn, $_POST['id_producte'], $_POST['nova_categoria']);
}

//Eliminar categoria
if (isset($_POST['btn_eliminar_categoria'])) {
    $id_cat_a_esborrar = $_POST['id_categoria'];

    //Evitem borrar la categoria "Sense Categoria" que és la que s'assigna als productes que no tenen categorias
    if ($id_cat_a_esborrar != 1) {
        eliminarCategoria($conn, $id_cat_a_esborrar);
    }
}

//Afegir categoria
if (isset($_POST['btn_afegir_categoria'])) {
    afegirCategoria($conn, $_POST['nom_cat'], $_POST['desc_cat']);
}

//Eliminar producte
if (isset($_POST['btn_eliminar_producte'])) {
    $id_p = $_POST['id_producte'];

    //Obtenim les dades del producte per saber la ruta de la carpeta de les imatges
    $dades_p = obtenirProductePerId($conn, $id_p);

    if ($dades_p) {
        //La imatge_url és "nom_carpeta/image1.png", volem només el nom de la carpeta
        //Agafem el nom de la carpeta separant per "/" i agafant la primera part
        $parts = explode('/', $dades_p['imatge_url']);
        if (count($parts) > 0) {
            $nom_carpeta = $parts[0];
            $ruta_completa = "content/products/" . $nom_carpeta;

            //Esborrem la carpeta i tot el seu contingut
            eliminarDirectoriRecursiu($ruta_completa);
        }

        //Esborrem el producte de la base de dades
        eliminarProducte($conn, $id_p);
    }
}

//Afegir producte
if (isset($_POST['btn_afegir_producte'])) {
    $nom = $_POST['nom'];
    $marca = $_POST['marca'];
    $descripcio = $_POST['descripcio'];
    $preu = $_POST['preu'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria'];

    //Transformem el nom del producte en un format adequat per la carpeta (minúscules i guions baixos)
    $nom_carpeta = strtolower(str_replace(' ', '_', $nom));
    //Ruta on es crearà la carpeta
    $ruta_directori = "content/products/" . $nom_carpeta;

    //Creem el directori si no existeix
    if (!file_exists($ruta_directori)) {
        mkdir($ruta_directori, 0777, true);
    }

    $imatge_url_bd = "";

    //Pugem la imatge principal com a image1.png
    if (isset($_FILES['imatge_principal']) && $_FILES['imatge_principal']['error'] === 0) {
        $ruta_principal = $ruta_directori . "/image1.png";
        //Pugem la imatge al directori creat i la guardem amb el nom "image1.png"
        move_uploaded_file($_FILES['imatge_principal']['tmp_name'], $ruta_principal);

        //Guardem a la BD només la ruta relativa (nom_carpeta/image1.png)
        $imatge_url_bd = $nom_carpeta . "/image1.png";
    }

    //Pugem les imatges secundàries (image2.png, image3.png etc)
    if (isset($_FILES['imatges_secundaries'])) {
        //Comprovem quantes imatges secundàries s'han pujat
        $total_secundaries = count($_FILES['imatges_secundaries']['name']);
        for ($i = 0; $i < $total_secundaries; $i++) {
            //Si no hi ha error en la pujada 
            if ($_FILES['imatges_secundaries']['error'][$i] === 0) {
                //Comencem pel número 2, ja que la principal és la 1
                $numero_imatge = $i + 2;
                $ruta_secundaria = $ruta_directori . "/image" . $numero_imatge . ".png";
                move_uploaded_file($_FILES['imatges_secundaries']['tmp_name'][$i], $ruta_secundaria);
            }
        }
    }

    //Inserim el producte a la base de dades
    afegirProducte($conn, $nom, $marca, $descripcio, $preu, $stock, $imatge_url_bd, $categoria_id);
}

$categories_disponibles = obtenirCategories($conn);
$usuaris = obtenirTotsUsuaris($conn);
$comandes = obtenirTotesLesComandesActives($conn);
//Utilitzem la mateixa funció que a la botiga però sense filtres per obtenir tots els productes
$productes = obtenirProductesFiltrats($conn, "", [], [], "");

include "views/adminpanel_view.php";
