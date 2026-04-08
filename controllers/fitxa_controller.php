<?php
require_once "models/producte.php";

//Mirem si ens han passat un ID de producte per mostrar la seva fitxa, sinó tornarem a la botiga
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $p = obtenirProductePerId($conn, $id);

    if (!$p) {
        die("Producte no trobat.");
    }

    //A partir de la URL de la imatge principal, obtenim el directori on es troben les altres imatges del producte
    $carpeta_producte = dirname($p['imatge_url']);
    $ruta_absoluta = "content/products/" . $carpeta_producte;

    $imatges_galeria = [];

    //Comprovem que el directori realment existeix
    if (is_dir($ruta_absoluta)) {
        //scandir llegeix tot el que hi ha a la carpeta, array_diff treu el "." i ".." 
        $arxius = array_diff(scandir($ruta_absoluta), array('.', '..'));

        foreach ($arxius as $arxiu) {
            //Ens assegurem de només agafar arxius que siguin imatges
            if (preg_match("/\.(png|jpg|jpeg|webp|gif)$/i", $arxiu)) {
                $imatges_galeria[] = $carpeta_producte . '/' . $arxiu;
            }
        }
    }

    include "views/fitxa_view.php";
} else {
    header("Location: index.php?accio=botiga");
}
