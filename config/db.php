<?php
//fitxer per la connexió a la base de dades

//variables de connexió
$host = "127.0.0.1:3307";
$user = "techcorner_admin";
$pass = "admin@123";          
$db_name = "techcorner_db";

// Creem la connexió
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Si hi ha un error de connexió, mostrem un missatge d'error i aturem l'execució
if (!$conn) {
    die("Error de connexió: " . mysqli_connect_error());
}

// Establim el conjunt de caràcters a utf8
mysqli_set_charset($conn, "utf8");
?>