<?php
require_once "models/producte.php";

//Obtenim 4 productes a l'atzar per al "carrusel"
$productes_destacats = obtenirProductesRandom($conn, 4);

//Obtenim les categories per mostrar-les com a accessos ràpids
$categories = obtenirCategories($conn);

//Carreguem la vista
include "views/home_view.php";
