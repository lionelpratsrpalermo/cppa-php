<?php
include_once '../database/connection.php';
include_once '../sql_queries.php';
include_once '../helpers.php';

if ($_POST) {
    $oneToOneHistorial = oneToOne($_POST['player1'], $_POST['player2']);
    $oneToOneHistorial = mysqli_query($connection, $oneToOneHistorial);

    $oneToOneHistorialArray = [];
    while ($row = mysqli_fetch_array($oneToOneHistorial, MYSQLI_ASSOC)) {
        array_push($oneToOneHistorialArray, $row);
    }

    echo "<pre>";
    print_r($oneToOneHistorialArray);

    echo "</pre>";
}

$queryListPlayers = allPlayers();
$queryResultListPlayer = mysqli_query($connection, $queryListPlayers);
$players = [];
while ($row = mysqli_fetch_array($queryResultListPlayer, MYSQLI_ASSOC)) {
    array_push($players, $row);
}

foreach ($players as $key => $value) {
    $surname[$key] = $value['apellido'];
    $name[$key] = $value['nombre'];
}
array_multisort($surname, SORT_ASC, $name, SORT_ASC, $players);

echo "<pre>";
print_r($players);
echo "</pre>";

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="es">

<?php include_once 'layout/head.php'; ?>


<body class="bg-success position-relative d-flex flex-column justify-content-between body">

    <?php include_once 'layout/header.php'; ?>

    <main class="container mb-3 align-self-center">
        <form class="row bg-success fw-bold p-4 pb-0 mb-3" action="head_to_head.php" method="POST">
            <div class="col-12 rounded p-4 pb-0">
                <div class="row border border-light p-3 mb-0 rounded">
                    <?php for ($i = 1; $i < 3; $i++) { ?>
                        <div class="col-md-4 mb-3">
                            <select class="form-select text-capitalize" aria-label="Default select example" name="player<?php echo $i; ?>">
                                <option value="">Jugador</option>
                                <?php foreach ($players as $player) { ?>
                                    <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['apellido'] . ', ' . $player['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary fs-5 fw-bold py-1">Ver historial</button>
                    </div>
                </div>
            </div>
        </form>
        <?php if ($_POST) {
            $posPlayer1 = array_search($_POST['player1'], array_column($players, 'id'));
            $posPlayer2 = array_search($_POST['player2'], array_column($players, 'id'));
        ?>
            <h1 class="text-warning fw-bold my-5">Historial <span class="text-capitalize"><?php echo $players[$posPlayer1]['apodo']; ?></span> vs. <span class="text-capitalize"><?php echo $players[$posPlayer2]['apodo']; ?></span></h1>
            <div class="col-12">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">GS #</th>
                            <th scope="col">Fecha #</th>
                            <th scope="col">Instancia</th>
                            <th scope="col">Equipo ganador</th>
                            <th scope="col">Equipo perdedor</th>
                            <th scope="col">1° set</th>
                            <th scope="col">2° set</th>
                            <th scope="col">3° set</th>
                            <th scope="col">4° set</th>
                            <th scope="col">5° set</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($oneToOneHistorialArray as $match) { ?>
                            <tr>
                                <td><?php echo formatDate($match['fecha'], '-'); ?></td>
                                <td><?php echo $match['grand_slam']; ?></td>
                                <td><?php echo $match['fecha_nro']; ?></td>
                                <td class="text-capitalize"><?php echo $match['instancia']; ?></td>
                                <td scope="row" class="text-capitalize fw-bold text-warning">
                                    <?php
                                    $playerId = array_search($match['ganador1'], array_column($players, 'id'));
                                    echo $players[$playerId]['apodo'] . " / ";
                                    $playerId = array_search($match['ganador2'], array_column($players, 'id'));
                                    echo $players[$playerId]['apodo'];
                                    ?>
                                </td>
                                <td class="text-capitalize">
                                    <?php
                                    $playerId = array_search($match['perdedor1'], array_column($players, 'id'));
                                    echo $players[$playerId]['apodo'] . " / ";
                                    $playerId = array_search($match['perdedor2'], array_column($players, 'id'));
                                    echo $players[$playerId]['apodo'];
                                    ?>
                                </td>
                                <td>
                                    <!-- set 1 -->
                                    <?php
                                    $gamesWinnerSet = substr($match['set1ganador'], 0, 1);
                                    $gamesLooserSet = substr($match['set1perdedor'], 0, 1);
                                    $pos = strpos($match['set1ganador'], '(');
                                    if ($pos != '') {
                                        $tbResult = substr($match['set1ganador'], $pos); // hallo la posicion donde se encuentra '(' y almaceno el resultado el tb == (7-4) o (4-7)
                                        echo $gamesWinnerSet . '-' . $gamesLooserSet . ' ' . $tbResult;
                                    } else
                                        echo $gamesWinnerSet . '-' . $gamesLooserSet;
                                    ?>
                                </td>
                                <td>
                                    <!-- set 2 -->
                                    <?php
                                    $gamesWinnerSet = substr($match['set2ganador'], 0, 1);
                                    $gamesLooserSet = substr($match['set2perdedor'], 0, 1);
                                    $pos = strpos($match['set2ganador'], '(');
                                    if ($pos != '') {
                                        $tbResult = substr($match['set2ganador'], $pos); // hallo la posicion donde se encuentra '(' y almaceno el resultado el tb == (7-4) o (4-7)
                                        echo $gamesWinnerSet . '-' . $gamesLooserSet . ' ' . $tbResult;
                                    } else
                                        echo $gamesWinnerSet . '-' . $gamesLooserSet;
                                    ?>
                                </td>
                                <td class="text-uppercase">
                                    <?php
                                    if (substr($match['set3ganador'], 0, 2) == 'tb') {
                                        echo $match['set3ganador'];
                                    } else {
                                        echo $match['set3ganador'] . " - " . $match['set3perdedor'];
                                    } ?>
                                </td>
                                <td>
                                    <?php
                                    if ($match['set4ganador'] == 0 and $match['set4perdedor'] == 0) {
                                        echo "-";
                                    } else {
                                        echo $match['set4ganador'] . " - " . $match['set4perdedor'];
                                    } ?>
                                </td>
                                <td class="text-uppercase">
                                    <?php
                                    if ($match['set5ganador'] == 0 and $match['set5perdedor'] == 0) {
                                        echo "-";
                                    } else {
                                        echo $match['set5ganador'] . " - " . $match['set5perdedor'];
                                    } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </main>
    <?php include_once 'layout/footer.php'; ?>
</body>

</html>