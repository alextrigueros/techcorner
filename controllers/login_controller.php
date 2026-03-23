<?php
//Carreguem el model d'usuari
require_once "models/usuari.php";

//Quan polsem el botó de login
if (isset($_POST['btn_login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    //Comprovem les credencials de l'usuari
    $usuari_valid = comprovarUsuari($conn, $email, $pass);

    //Si les credencials són correctes, guardem les dades a la sessió i anem a la home
    //Si no son correctes creem un error
    if ($usuari_valid) {
        $_SESSION['user_id'] = $usuari_valid['usuari_id'];
        $_SESSION['user_nom'] = $usuari_valid['nom'];
        header("Location: index.php");
        exit;
    }
    else {
        $error = "Email o contrasenya incorrectes";
    }
}

//Carreguem la vista
include "views/login_view.php";
