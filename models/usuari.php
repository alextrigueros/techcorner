<?php
//Funcio per comprovar les credencials de l'usuari
function comprovarUsuari($conn, $email, $password)
{
    //Busquem l'usuari per email
    $sql = "SELECT * FROM USUARIS WHERE email = '$email'";
    $resultat = mysqli_query($conn, $sql);
    $usuari = mysqli_fetch_assoc($resultat);

    //Si existeix l'usuari i la contrasenya coincideix
    if ($usuari && $usuari['contrasenya'] == $password) {
        return $usuari; // Retornem les dades de l'usuari
    }
    return false; //Si no coincideix, retornem fals
}

//Funció per veure si un email ja està agafat
function existeixEmail($conn, $email)
{
    $sql = "SELECT email FROM USUARIS WHERE email = '$email'";
    $resultat = mysqli_query($conn, $sql);

    //Si troba alguna fila, vol dir que l'email ja existeix
    if (mysqli_num_rows($resultat) > 0) {
        return true;
    } else {
        return false;
    }
}

//Funció per inserir el nou usuari a la base de dades
function registrarUsuari($conn, $nom, $cognoms, $email, $password)
{
    $sql = "INSERT INTO USUARIS (nom, cognoms, email, contrasenya) VALUES ('$nom', '$cognoms', '$email', '$password')";

    //Si la comanda funciona, retornem true
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

//Funció per obtenir les dades de l'usuari a partir del seu ID
function obtenirDadesUsuari($conn, $usuari_id) {
    $sql = "SELECT nom, cognoms, email FROM USUARIS WHERE usuari_id = $usuari_id";
    $resultat = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($resultat);
}

//Funció per obtenir les comandes d'un usuari a partir del seu ID
function obtenirComandesUsuari($conn, $usuari_id) {
    //Les ordenem per data de més nova a més antiga (DESC)
    $sql = "SELECT comanda_id, data_comanda, total, estat 
            FROM COMANDES 
            WHERE usuari_id = $usuari_id 
            ORDER BY data_comanda DESC";
    $resultat = mysqli_query($conn, $sql);
    return mysqli_fetch_all($resultat, MYSQLI_ASSOC);
}
