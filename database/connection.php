<?php
require 'db_data.php';
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
// $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
    echo "Error de conexión a la DDBB";
    exit();
}
// mysqli_set_charset($connection, 'utf-8');
mysqli_select_db($connection, DB_NAME) or die('No se encunentra la DDBB');
