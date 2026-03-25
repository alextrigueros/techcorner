<?php
//Funcio per obtenir els productes segons els filtres que ens arriben del controller
function obtenirProductesFiltrats($conn, $cerca, $categories, $marques, $ordre)
{
    //Consulta base on tenim 1=1 per poder anar afegint condicions nomes amb AND
    $sql = "SELECT * FROM PRODUCTES WHERE 1=1";

    //Si l'usuari ha buscat una paraula al cercador
    if ($cerca != "") {
        //Posem % al principi i al final per buscar aquesta paraula en qualsevol part del nom o la descripcio
        $sql = $sql . " AND (nom LIKE '%$cerca%' OR descripcio LIKE '%$cerca%')";
    }

    //Si l'usuari ha marcat categories (ens arriba un array)
    if (count($categories) > 0) {
        // Transformem l'array en una llista separada per comes
        $llista_cats = implode(",", $categories);
        $sql = $sql . " AND categoria_id IN ($llista_cats)";
    }

    //Si l'usuari ha marcat marques
    if (count($marques) > 0) {
        //Com que les marques són text, hem de posar cometes per que arribin com a text a la consulta
        $llista_marques = "'" . implode("','", $marques) . "'";
        $sql = $sql . " AND marca IN ($llista_marques)";
    }

    //Ordre
    if ($ordre == "preu_asc") {
        $sql = $sql . " ORDER BY preu ASC";
    } elseif ($ordre == "preu_desc") {
        $sql = $sql . " ORDER BY preu DESC";
    }
    //Executem la consulta final
    $resultat = mysqli_query($conn, $sql);
    //Retornem els resultats com un array associatiu
    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}

//Funcions per obtenir les categories i marques (per mostrar els filtres a la vista)
function obtenirCategories($conn)
{
    $res = mysqli_query($conn, "SELECT * FROM CATEGORIES");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

function obtenirMarquesUniques($conn)
{
    $res = mysqli_query($conn, "SELECT DISTINCT marca FROM PRODUCTES");
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}

//Funció per obtenir un producte concret segons el seu ID (per mostrar la fitxa de producte)
function obtenirProductePerId($conn, $id)
{
    $sql = "SELECT * FROM PRODUCTES WHERE producte_id = $id";
    $resultat = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($resultat);
}

//Funció per augmentar l'stock d'un producte
function modificarStock($conn, $id, $quantitat)
{
    // Sumem la quantitat a l'stock actual
    $sql = "UPDATE PRODUCTES SET stock = stock + $quantitat WHERE producte_id = $id";
    return mysqli_query($conn, $sql);
}

//Funció per afegir una nova categoria
function afegirCategoria($conn, $nom, $descripcio)
{
    $sql = "INSERT INTO CATEGORIES (nom, descripcio) VALUES ('$nom', '$descripcio')";
    return mysqli_query($conn, $sql);
}

//Funció per afegir un nou producte
function afegirProducte($conn, $nom, $marca, $descripcio, $preu, $stock, $imatge_url, $categoria_id)
{
    $sql = "INSERT INTO PRODUCTES (nom, marca, descripcio, preu, stock, imatge_url, categoria_id) 
            VALUES ('$nom', '$marca', '$descripcio', $preu, $stock, '$imatge_url', $categoria_id)";
    return mysqli_query($conn, $sql);
}

//Funció per esborrar un producte
function eliminarProducte($conn, $id)
{
    $sql = "DELETE FROM PRODUCTES WHERE producte_id = $id";
    return mysqli_query($conn, $sql);
}

//Funció per esborrar una categoria
function eliminarCategoria($conn, $id)
{
    $sql = "DELETE FROM CATEGORIES WHERE categoria_id = $id";
    return mysqli_query($conn, $sql);
}

//Funció per actualitzar la categoria d'un producte
function actualitzarCategoriaProducte($conn, $id_producte, $id_categoria)
{
    $sql = "UPDATE PRODUCTES SET categoria_id = $id_categoria WHERE producte_id = $id_producte";
    return mysqli_query($conn, $sql);
}

//Funció per esborrar un directori i tot el seu contingut (per eliminar les imatges i directori d'un producte quan s'elimina el producte)
function eliminarDirectoriRecursiu($dir)
{
    //Si el directori no existeix, retornem true perquè ja està "esborrat"
    if (!file_exists($dir)) return true;
    // Si no és un directori, el borrem directament amb unlink
    if (!is_dir($dir)) return unlink($dir);

    //Si és un directori, recorrem el seu contingut amb scandir que retorna un array i borrem recursivament cada element
    foreach (scandir($dir) as $item) {
        //(IMPORTANT!) Ignorem els elements "." i ".." que representen el directori actual i el directori pare
        if ($item == '.' || $item == '..') continue;
        //Borrat recursiu: si algun element és un directori, s'entrarà a la funció i esborrarà el seu contingut abans de borrar el directori
        //Utilitzem DIRECTORY_SEPARATOR per assegurar la compatibilitat entre sistemes operatius respecte les barres "\" "/"
        if (!eliminarDirectoriRecursiu($dir . DIRECTORY_SEPARATOR . $item)) return false;
    }
    //Quan ja hem esborrat tot el contingut, esborrem el directori final
    return rmdir($dir);
}
