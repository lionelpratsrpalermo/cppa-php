<?php

$arrayLoco = array(
    '75' =>
    array(
        'id' => 1,
        'apellido' => 'balestrini',
        'nombre' => 'sergio'
    ),
    '45' => array(
        'id' => 2,
        'apellido' => 'fiorini',
        'nombre' => 'santiago'
    ),
    '15' => array(
        'id' => 3,
        'apellido' => 'prats',
        'nombre' => 'lionel',
    ),
    '8' => array(
        'id' => 4,
        'apellido' => 'peverelli',
        'nombre' => 'juan ignacio'
    ),
    '19' => array(
        'id' => 5,
        'apellido' => 'tolosa',
        'nombre' => 'mariano'
    ),
    '60' => array(
        'id' => 6,
        'apellido' => 'zinser',
        'nombre' => 'mariano'
    ),
    '33' => array(
        'id' => 7,
        'apellido' => 'gambetta',
        'nombre' => 'gaston'
    ),
);

foreach ($arrayLoco as $key => $value) {
    $apellido[$key] = $value['apellido'];
    $nombre[$key] = $value['nombre'];
}
array_multisort($apellido, SORT_ASC, $nombre, SORT_ASC, $arrayLoco);
/* echo "<pre>";
print_r($arrayLoco);
echo "</pre>"; */

$string = "6-7 (7-3)";

$mystring = '6-7 (7-3)';
$findme   = '8';
$pos = strpos($mystring, $findme);

// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
// porque la posición de 'a' está en el 1° (primer) caracter.
/* if ($pos === false) {
    echo "El caracter '$findme' no se encuentra en el string '$mystring' (valor de pos: $pos).";
} else {
    echo "El caracter '$findme' se encuentra en la posicion $pos del string '$mystring'";
} */

/* echo "<br>";
echo substr($string, 4);
echo "<br>"; */

$ganador = '6 (8-10)';
$perdedor = '7 (10-8)';
$gamesWinnerSet = substr($ganador, 0, 1);
$gamesLooserSet = substr($perdedor, 0, 1);
$pos = strpos($ganador, '(');

/* echo $pos . "<br>"; */

/* if ($pos != '') {
    $tbResult = substr($ganador, $pos); // hallo la posicion donde se encuentra '(' y almaceno el resultado el tb == (7-4) o (4-7)
    echo $gamesWinnerSet . '-' . $gamesLooserSet . ' ' . $tbResult;
} else
    echo $gamesWinnerSet . '-' . $gamesLooserSet; */

/* echo $pos . "<br>";
echo $tbResult . "<br>"; */

/* if (!$pos)
    echo $ganador . '-' . $perdedor . ' ' . $tbResult;
else
    echo $ganador . '-' . $perdedor; */



echo "<pre>";
print_r($arrayLoco);
echo "</pre>";

$people = array(
    2 => array(
        'name' => 'John',
        'fav_color' => 'green'
    ),
    5 => array(
        'name' => 'Samuel',
        'fav_color' => 'blue'
    )
);

$found_key = array_search(3, array_column($arrayLoco, 'id'));

echo "<pre>";
print_r($found_key);
echo "</pre>";

/* $registros = array(
    array(
        'id' => 2135,
        'nombre' => 'John',
        'apellido' => 'Doe',
    ),
    array(
        'id' => 3245,
        'nombre' => 'Sally',
        'apellido' => 'Smith',
    ),
    array(
        'id' => 5342,
        'nombre' => 'Jane',
        'apellido' => 'Jones',
    ),
    array(
        'id' => 5623,
        'nombre' => 'Peter',
        'apellido' => 'Doe',
    )
);

$nombres = array_column($registros, 'nombre');
print_r($nombres); */
