<?php
require_once "models/usuari.php";

// Si s'ha premut el botó de "Registrar-se"
if (isset($_POST['btn_registre'])) {

    // Guardem el que l'usuari ha escrit en variables
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $nom = ucfirst(strtolower($nom));

    //Comprovem si l'email ja existeix
    if (existeixEmail($conn, $email) == true) {
        $error = "Aquest correu electrònic ja està registrat.";
    } else {
        //Si no existeix, el registrem
        $registre_ok = registrarUsuari($conn, $nom, $cognoms, $email, $password);

        if ($registre_ok == true) {
            // Si tot ha anat bé, anem a la pantalla de login
            header("Location: index.php?accio=login");
            exit;
        }
        // Si hi ha hagut un error a la base de dades, creem un error 
        else {
            $error = "Hi ha hagut un error a la base de dades al intentar registrar-te.";
        }
    }
}

//Carreguem la vista
include "views/registre_view.php";
