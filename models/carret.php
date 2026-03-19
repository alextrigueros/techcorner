<?php
//Funció per obtenir o crear un carret per a un usuari
function obtenirIdCarret($conn, $usuari_id)
{
    //Mirem si l'usuari ja té un carret obert
    $sql = "SELECT carret_id FROM CARRETS WHERE usuari_id = $usuari_id";
    $resultat = mysqli_query($conn, $sql);
    $carret = mysqli_fetch_assoc($resultat);

    if ($carret) {
        return $carret['carret_id'];
    } else {
        //Si no en té, el creem
        $sql_crear = "INSERT INTO CARRETS (usuari_id) VALUES ($usuari_id)";
        mysqli_query($conn, $sql_crear);
        //Utilitzem mysqli_insert_id per obtenir l'ID del carret que acabem de crear
        return mysqli_insert_id($conn);
    }
}

// Funció per afegir un producte al detall del carret
function afegirProducteAlCarret($conn, $carret_id, $producte_id)
{
    //Mirem si el producte ja hi és al carret
    $sql_check = "SELECT detall_carret_id, quantitat FROM DETALL_CARRETS WHERE carret_id = $carret_id AND producte_id = $producte_id";
    $res = mysqli_query($conn, $sql_check);
    $existent = mysqli_fetch_assoc($res);

    if ($existent) {
        //Si ja hi és sumem 1 a la quantitat del producte
        $nova_quantitat = $existent['quantitat'] + 1;
        $detall_id = $existent['detall_carret_id'];
        $sql_update = "UPDATE DETALL_CARRETS SET quantitat = $nova_quantitat WHERE detall_carret_id = $detall_id";
        return mysqli_query($conn, $sql_update);
    } else {
        //Si no hi és l'afegim amb quantitat 1
        $sql_insert = "INSERT INTO DETALL_CARRETS (carret_id, producte_id, quantitat) 
                       VALUES ($carret_id, $producte_id, 1)";
        return mysqli_query($conn, $sql_insert);
    }
}

//Funció per obtenir tots els productes del carret d'un usuari
function obtenirProductesCarret($conn, $usuari_id)
{
    //Fem un join per obtenir el nom, preu, imatge i quantitat de cada producte que hi ha al carret de l'usuari
    $sql = "SELECT p.nom, p.preu, p.imatge_url, dc.quantitat, dc.detall_carret_id, p.producte_id
            FROM CARRETS c
            JOIN DETALL_CARRETS dc ON c.carret_id = dc.carret_id
            JOIN PRODUCTES p ON dc.producte_id = p.producte_id
            WHERE c.usuari_id = $usuari_id";

    $resultat = mysqli_query($conn, $sql);
    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}
