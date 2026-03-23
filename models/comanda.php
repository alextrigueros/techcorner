<?php
//Funció per finalitzar la compra, que crea una comanda i buida el carret
function finalitzarCompra($conn, $usuari_id)
{
    //Obtenim el carret de l'usuari
    $sql_carret = "SELECT carret_id FROM CARRETS WHERE usuari_id = $usuari_id";
    $res_carret = mysqli_query($conn, $sql_carret);
    $carret = mysqli_fetch_assoc($res_carret);

    //Si no té carret retornem false ja que no es pot fer la comanda
    if (!$carret) {
        return false;
    }
    $carret_id = $carret['carret_id'];

    //Obtenim els productes del carret per saber que hem de moure
    $sql_prods = "SELECT dc.producte_id, dc.quantitat, p.nom, p.preu, p.stock 
                  FROM DETALL_CARRETS dc 
                  JOIN PRODUCTES p ON dc.producte_id = p.producte_id 
                  WHERE dc.carret_id = $carret_id";
    $res_prods = mysqli_query($conn, $sql_prods);
    $productes = mysqli_fetch_all($res_prods, MYSQLI_ASSOC);

    //Si el carret està buit, no fem cap comanda
    if (count($productes) == 0) {
        return false;
    }
    //Comprovem que hi ha prou stock de cada producte abans de crear la comanda
    foreach ($productes as $p) {
        //Si la quantitat que l'usuari vol comprar és superior a l'stock disponible, retornem un error indicant quin producte no té prou stock
        if ($p['quantitat'] > $p['stock']) {
            return "Error: No hi ha prou stock del producte: " . $p['nom'];
        }
    }
    //Calculem el total multiplicant el preu de cada producte per la seva quantitat i sumant-ho tot
    $total = 0;
    foreach ($productes as $p) {
        $total = $total + ($p['preu'] * $p['quantitat']);
    }

    //Creem la comanda a la taula COMANDES, amb l'estat pendent
    $sql_comanda = "INSERT INTO COMANDES (usuari_id, total, estat) VALUES ($usuari_id, $total, 'pendent')";
    mysqli_query($conn, $sql_comanda);
    //Obtenim l'ID de la comanda que acabem de crear per poder relacionar els detalls
    $comanda_id = mysqli_insert_id($conn);

    //Per cada producte del carret, creem un detall de comanda a la taula DETALL_COMANDES
    foreach ($productes as $p) {
        $prod_id = $p['producte_id'];
        $quant = $p['quantitat'];
        $preu = $p['preu'];

        $sql_detall = "INSERT INTO DETALL_COMANDES (comanda_id, producte_id, quantitat, preu_unitari) 
                       VALUES ($comanda_id, $prod_id, $quant, $preu)";
        mysqli_query($conn, $sql_detall);
    }
    //Per últim, buidem el carret de l'usuari ja que la compra s'ha finalitzat
    $sql_buidar = "DELETE FROM DETALL_CARRETS WHERE carret_id = $carret_id";
    mysqli_query($conn, $sql_buidar);

    return true;
}
