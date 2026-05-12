<?php
//Capçalera per indicar que retornem JSON amb codificació UTF-8
header('Content-Type: application/json; charset=utf-8');


$ruta_python = "C:\Users\alext\AppData\Local\Programs\Python\Python313\python.exe";
$ruta_script = realpath(__DIR__ . "/../assets/py/chatbot.py");


if (isset($_POST['missatge'])) {
    $missatge = $_POST['missatge'];
} else {
    $missatge = '';
}
if (isset($_POST['historial'])) {
    $historial = $_POST['historial'];
} else {
    $historial = '[]';
}
if (isset($_FILES['imatge'])) {
    $imatge = $_FILES['imatge'];
} else {
    $imatge = null;
}

$ruta_imatge_final = "";

//Si hi ha imatge, la guardem a una carpeta temporal
if ($imatge && $imatge['error'] === UPLOAD_ERR_OK) {
    $nom_fitxer = time() . "_" . $imatge['name'];
    $carpeta_temp = __DIR__ . "/../assets/images/temp_xat/";
    //Creem la carpeta temporal si no existeix
    if (!is_dir($carpeta_temp)) mkdir($carpeta_temp, 0777, true);

    $ruta_imatge_final = $carpeta_temp . $nom_fitxer;
    move_uploaded_file($imatge['tmp_name'], $ruta_imatge_final);
}

//Convertim l'historial a Base64 per evitar problemes amb caràcters especials
$historial_b64 = base64_encode($historial);

//Escapem el missatge per evitar injeccions de codi
$arg_missatge = escapeshellarg($missatge);

//Si hi ha imatge, passem la ruta escapada, sinó passem "none"
if ($ruta_imatge_final) {
    $arg_imatge = escapeshellarg($ruta_imatge_final);
} else {
    $arg_imatge = "none";
}

//Escapem l'historial en Base64 per passar-lo com a argument al script Python
$arg_historial = escapeshellarg($historial_b64);

//Executem el script passant el missatge i la imatge si hi ha. Posem 2>&1 per capturar els errors del script Python
//Fem servir \" per especificar rutes amb espais sense que doni error
$comanda = "\"$ruta_python\" \"$ruta_script\" $arg_missatge $arg_imatge $arg_historial 2>&1";

//Executem la comanda en mode lectura per capturar la sortida del script Python
$execucio = "";
$proc = popen($comanda, 'r');

//Comprovem que el procés s'ha iniciat correctament abans de llegir la sortida
if (is_resource($proc)) {
    //Bucle per llegir la sortida del script Python fins que acabi l'execució
    while (!feof($proc)) {
        //Llegim un fragment de la sortida del script Python i l'anem afegint a la variable $execucio
        $fragment = fread($proc, 4096);
        $execucio .= $fragment;
    }
    //Tanquem el procés un cop acabada l'execució
    pclose($proc);
}

//Retornem la resposta del script Python com a JSON
echo json_encode(["resposta" => trim($execucio)]);

//Eliminem la imatge temporal si hi ha, després d'executar el script
if ($ruta_imatge_final && file_exists($ruta_imatge_final)) {
    unlink($ruta_imatge_final);
}
