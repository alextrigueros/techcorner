<?php
require_once "models/usuari.php";

//Si l'usuari no està loguejat, el redirigim al login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?accio=login");
    exit;
}

$usuari_id = $_SESSION['user_id'];

//Si s'ha premut el botó de canviar contrasenya
if (isset($_POST['btn_canviar_pass'])) {
    $pass_actual = $_POST['pass_actual'];
    $nova_pass = $_POST['nova_pass'];
    $nova_pass_confirm = $_POST['nova_pass_confirm'];

    //Obtenim el hash de la contrasenya actual de la base de dades
    $hash_actual = obtenirHashContrasenya($conn, $usuari_id);

    //Verifiquem si la contrasenya actual escrita és correcta
    if (!password_verify($pass_actual, $hash_actual)) {
        $error_password = "La contrasenya actual no és correcta.";
    }
    //Comprovem que les dues noves coincideixin
    elseif ($nova_pass !== $nova_pass_confirm) {
        $error_password = "Les noves contrasenyes no coincideixen.";
    }
    //Si tot és correcte, xifrem i guardem
    else {
        $nou_hash = password_hash($nova_pass, PASSWORD_DEFAULT);
        if (actualitzarContrasenya($conn, $usuari_id, $nou_hash)) {
            $msg_password = "Contrasenya actualitzada correctament!";
        } else {
            $error_password = "Error al inserir a la base de dades.";
        }
    }
}

//Demanem les dades al model
$usuari = obtenirDadesUsuari($conn, $usuari_id);
$comandes = obtenirComandesUsuari($conn, $usuari_id);

//Carreguem la vista
include "views/perfil_view.php";
