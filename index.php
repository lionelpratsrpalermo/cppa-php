<!DOCTYPE html>
<html lang="es">

<?php include_once 'layout/head.php'; ?>


<body class="bg-success position-relative d-flex flex-column justify-content-between body">

    <?php include_once 'layout/header.php'; ?>

    <main class="container mb-3 align-self-center">
        <?php
        // Inicio el manejo de sesiones.
        session_start();

        // Puedo usar cualquier elemento del arreglo

        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";

        ?>
    </main>

    <?php include_once 'layout/footer.php'; ?>
</body>

</html>