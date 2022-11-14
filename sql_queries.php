<?php

function findLastMatch($fieldToFind = '')
{
    if ($fieldToFind != '')
        $query =  "SELECT $fieldToFind FROM partido ORDER BY id DESC LIMIT 1";
    else
        $query =  "SELECT * FROM partido ORDER BY id DESC LIMIT 1";
    return $query;
}

function allPlayers()
{
    $query = "SELECT id, apellido, nombre, apodo FROM jugador";
    return $query;
}

function oneToOne($player1, $player2)
{
    $query = "SELECT id, fecha, grand_slam, fecha_nro, instancia, ganador1, ganador2, perdedor1, perdedor2, set1ganador, set1perdedor, set2ganador, set2perdedor, set3ganador, set3perdedor, set4ganador, set4perdedor, set5ganador, set5perdedor
    FROM partido
    WHERE ((ganador1 = $player1 OR ganador2 = $player1) AND (perdedor1 = $player2 OR perdedor2 = $player2)
    OR (ganador1 = $player2 OR ganador2 = $player2) AND (perdedor1 = $player1 OR perdedor2 = $player1))
    AND grand_slam >= 1
    ORDER BY fecha";

    return $query;
}
