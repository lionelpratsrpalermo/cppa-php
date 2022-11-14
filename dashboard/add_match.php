<?php
include_once 'layout/header.php';
include_once '../database/connection.php';
include_once '../sql_queries.php';
if ($_POST) {
    $age = $_POST['age'];
    $date_match = $_POST['date_match'];
    $stadium_match = $_POST['stadium_match'];
    $grand_slam = $_POST['grand_slam'];
    $meet = $_POST['meet'];
    $instance = $_POST['instance'];
    $winner1 = $_POST['winner1'];
    $winner2 = $_POST['winner2'];
    $looser1 = $_POST['looser1'];
    $looser2 = $_POST['looser2'];
    $arrayPointsMatch = [];
    for ($i = 1; $i <= 5; $i++) {
        if ($_POST['set' . $i . 'TB'] == '') {
            $pointsWinnerInSet = $_POST['set' . $i . 'winner'];
            $pointsLooserInSet = $_POST['set' . $i . 'looser'];
            array_push($arrayPointsMatch, $pointsWinnerInSet, $pointsLooserInSet);
        } else {
            $tb = $_POST['set' . $i . 'TB'];
            $tb = explode('-', $tb);
            $pointsWinnerInSet = $_POST['set' . $i . 'winner'] . ' (' . $tb[0] . '-' . $tb[1] . ')';
            $pointsLooserInSet = $_POST['set' . $i . 'looser'] . ' (' . $tb[1] . '-' . $tb[0] . ')';
            array_push($arrayPointsMatch, $pointsWinnerInSet, $pointsLooserInSet);
        }
    }
    $query = "INSERT INTO partido (era, fecha, estadio, grand_slam, fecha_nro, instancia, ganador1, ganador2, perdedor1, perdedor2, set1ganador, set1perdedor, set2ganador, set2perdedor, set3ganador, set3perdedor, set4ganador, set4perdedor, set5ganador, set5perdedor) 
    VALUES ('$age', '$date_match', '$stadium_match', '$grand_slam', '$meet', '$instance', '$winner1', '$winner2', '$looser1', '$looser2', '$arrayPointsMatch[0]', '$arrayPointsMatch[1]', '$arrayPointsMatch[2]' , '$arrayPointsMatch[3]' , '$arrayPointsMatch[4]', '$arrayPointsMatch[5]', '$arrayPointsMatch[6]' , '$arrayPointsMatch[7]' , '$arrayPointsMatch[8]','$arrayPointsMatch[9]')";

    $result = mysqli_query($connection, $query);

    /* busco el id del partido recien insertado en partido, para updatear la tabla resultado */
    $idLastUploadedMatch = findLastMatch('id');
    $idLastUploadedMatch = mysqli_query($connection, $idLastUploadedMatch);
    $idMatch = '';
    while ($row = mysqli_fetch_array($idLastUploadedMatch, MYSQLI_ASSOC)) {
        $idMatch = $row['id'];
    }

    $winners = [$winner1, $winner2];
    $loosers = [$looser1, $looser2];

    $totalGamesWinner = 0;
    $totalGamesLooser = 0;
    $sets;

    for ($i = 0; $i <= 3; $i++) {
        if ($i % 2 == 0) {
            $totalGamesWinner = $totalGamesWinner + substr($arrayPointsMatch[$i], 0, 1);
        } else {
            $totalGamesLooser =  $totalGamesLooser + substr($arrayPointsMatch[$i], 0, 1);
        }
    }

    if (substr($arrayPointsMatch[4], 0, 2) == "tb") {
        $totalGamesWinner = $totalGamesWinner + 1;
        $sets = [1, 1];
    } else
        $sets = [2, 0];

    $outStandingPerformance = $_POST['outstandingPerformance'];
    for ($i = 0; $i < count($winners); $i++) {
        $query2 =  "INSERT INTO resultado (id_partido, id_jugador, games_ganados, games_perdidos, sets_ganados, sets_perdidos, partidos_ganados, partidos_perdidos, actuacion_destacada) VALUES($idMatch, $winners[$i], $totalGamesWinner, $totalGamesLooser, $sets[0], $sets[1], 1, 0, $outStandingPerformance)";
        $query2 = mysqli_query($connection, $query2);
    }

    for ($i = 0; $i < count($loosers); $i++) {
        $query2 =  "INSERT INTO resultado (id_partido, id_jugador, games_ganados, games_perdidos, sets_ganados, sets_perdidos, partidos_ganados, partidos_perdidos, actuacion_destacada) VALUES($idMatch, $loosers[$i], $totalGamesLooser, $totalGamesWinner, $sets[1], $sets[0], 0, 1, 0)";
        $query2 = mysqli_query($connection, $query2);
    }
    // echo mysqli_affected_rows($connection); // -> nos informa cuantos registros se han visto afectados por una instruccion INSERT INTO, UPDATE o DELETE
}
$queryListPlayers = "SELECT id, apellido, nombre FROM jugador";
$queryResultListPlayer = mysqli_query($connection, $queryListPlayers);
$players = [];
while ($row = mysqli_fetch_array($queryResultListPlayer, MYSQLI_ASSOC)) {
    array_push($players, $row);
}

mysqli_close($connection);

?>

<form class="row bg-success fw-bold p-4 mb-5" action="add_match.php" method="POST">
    <input type="text" class="d-none" value="profesionalismo" name="age">
    <div class="col-12 border border-light rounded p-4 mb-3">
        <div class="text-warning h3 mb-3">Datos del partido</div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <label for="exampleInputEmail1" class="form-label h4">Fecha</label>
                <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="date_match">
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Estadio</label>
                <select class="form-select" aria-label="Default select example" name="stadium_match">
                    <option>Estadio</option>
                    <option value="cardenas 2685">Cárdenas 2685</option>
                </select>
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Grand Slam</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" min="1" value="1" name="grand_slam">
            </div>
        </div>
        <div class="row">
            <div class="d-none d-lg-block col-lg-2"></div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Fecha #</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" min="0" value="0" name="meet">
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Instancia</label>
                <select class="form-select" aria-label="Default select example" name="instance">
                    <option>Instancia</option>
                    <option value="semifinal">Semifinal</option>
                    <option value="final">Final</option>
                    <option value="3&4">3°&4° puesto</option>
                    <option value="finalisima">Finalísima</option>
                    <option value="frustradisima">Frustradísima</option>
                </select>
            </div>
            <div class="d-none d-lg-block col-lg-2"></div>
        </div>
    </div>
    <div class="col-12 border border-light rounded p-4 mb-3">
        <div class="text-warning h3 mb-3">Equipos</div>
        <div class="row border border-light p-3 mb-4 rounded">
            <div class="text-center h3 text-warning">Ganador</div>
            <div class="d-none d-lg-block col-lg-1"></div>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div class="col-md-6 col-lg-5">
                    <label for="exampleInputEmail1" class="form-label h4">Jugador <?php echo $i; ?></label>
                    <select class="form-select" aria-label="Default select example" name="winner<?php echo $i; ?>">
                        <option value="">Jugador</option>
                        <?php foreach ($players as $player) { ?>
                            <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['id'] . '. ' .  $player['nombre'] . ' ' . $player['apellido']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="d-none d-lg-block col-lg-1"></div>
        </div>
        <div class="row border border-light p-3 mb-2 rounded">
            <div class="text-center h3 text-warning">Perdedor</div>
            <div class="d-none d-lg-block col-lg-1"></div>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div class="col-md-6 col-lg-5">
                    <label for="exampleInputEmail1" class="form-label h4">Jugador <?php echo $i; ?></label>
                    <select class="form-select" aria-label="Default select example" name="looser<?php echo $i; ?>">
                        <option value="">Jugador</option>
                        <?php foreach ($players as $player) { ?>
                            <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['id'] . '. ' .  $player['nombre'] . ' ' . $player['apellido']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="d-none d-lg-block col-lg-1"></div>
        </div>
    </div>
    <div class="col-12 border border-light rounded p-4 mb-4">
        <div class="text-warning h3 mb-3">Resultado</div>
        <div class="row d-lg-flex justify-content-around">
            <?php for ($i = 1; $i < 6; $i++) { ?>
                <div class="col-sm-5 col-lg-2 border border-light rounded py-3 mb-3">
                    <div class="mb-3 h4"><?php echo $i; ?>° set</div>
                    <select class="form-select mb-3" aria-label="Default select example" name="set<?php echo $i; ?>winner">
                        <option value="0">Games ganador</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="tb">TB</option>
                    </select>

                    <select class="form-select mb-3" aria-label="Default select example" name="set<?php echo $i; ?>looser">
                        <option value="0">Games perdedor</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="tb">TB</option>
                    </select>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tie Break" name="set<?php echo $i; ?>TB">
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-12 border border-light rounded p-4 mb-4">
        <div class="row">
            <div class="col-sm-5 col-lg-2 border border-light rounded py-3 mb-3">
                <div class="mb-3 h4">Actuación destacada:</div>
                <select class="form-select mb-3" aria-label="Default select example" name="outstandingPerformance">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 fs-4 fw-bold py-1">Agregar partido</button>
    </div>
</form>

<?php include_once 'layout/footer.php'; ?>