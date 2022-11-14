<?php
include_once 'layout/header.php';
include_once '../database/connection.php';
include_once '../sql_queries.php';
if ($_POST) {
    $array_players = [
        $_POST['team_A_player1'],
        $_POST['team_A_player2'],
        $_POST['team_B_player1'],
        $_POST['team_B_player2'],
        $_POST['team_C_player1'],
        $_POST['team_C_player2'],
        $_POST['team_D_player1'],
        $_POST['team_D_player2']
    ];

    for ($i = 0; $i < count($array_players); $i++) {
        $query = "UPDATE proxima_fecha set id_jugador = $array_players[$i] WHERE id = $i";
        $result = mysqli_query($connection, $query);
    }
}
$queryListPlayers = "SELECT id, apellido, nombre FROM jugador";
$queryResultListPlayer = mysqli_query($connection, $queryListPlayers);
$players = [];
while ($row = mysqli_fetch_array($queryResultListPlayer, MYSQLI_ASSOC)) {
    array_push($players, $row);
}

mysqli_close($connection);

foreach ($players as $clave => $valor) {
    $apellido[$clave] = $valor['apellido'];
    $nombre[$clave] = $valor['nombre'];
}
array_multisort($apellido, SORT_ASC, $nombre, SORT_ASC, $players);

/* echo "<pre>";
print_r($players);
echo "</pre>"; */
?>

<form class="row bg-success fw-bold p-4 mb-5" action="next_meet.php" method="POST">
    <!-- <input type="text" class="d-none" value="profesionalismo" name="age"> -->
    <div class="col-12 border border-light rounded p-4 mb-3">
        <div class="text-warning h3 mb-3">Semifinal #1</div>
        <div class="row border border-light p-3 mb-4 rounded">
            <div class="text-center h3 text-warning">Equipo "A"</div>
            <div class="d-none d-lg-block col-lg-1"></div>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div class="col-md-6 col-lg-5">
                    <label for="exampleInputEmail1" class="form-label h4">Jugador <?php echo $i; ?></label>
                    <select class="form-select text-capitalize" aria-label="Default select example" name="team_A_player<?php echo $i; ?>">
                        <option value="" class="fw-bold">Jugador</option>
                        <?php foreach ($players as $player) { ?>
                            <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['apellido'] . ', ' . $player['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="d-none d-lg-block col-lg-1"></div>
        </div>
        <div class="row border border-light p-3 mb-2 rounded">
            <div class="text-center h3 text-warning">Equipo "D"</div>
            <div class="d-none d-lg-block col-lg-1"></div>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div class="col-md-6 col-lg-5">
                    <label for="exampleInputEmail1" class="form-label h4">Jugador <?php echo $i; ?></label>
                    <select class="form-select text-capitalize" aria-label="Default select example" name="team_D_player<?php echo $i; ?>">
                        <option value="">Jugador</option>
                        <?php foreach ($players as $player) { ?>
                            <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['apellido'] . ', ' . $player['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="d-none d-lg-block col-lg-1"></div>
        </div>
    </div>

    <div class="col-12 border border-light rounded p-4 mb-3">
        <div class="text-warning h3 mb-3">Semifinal #2</div>
        <div class="row border border-light p-3 mb-4 rounded">
            <div class="text-center h3 text-warning">Equipo "B"</div>
            <div class="d-none d-lg-block col-lg-1"></div>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div class="col-md-6 col-lg-5">
                    <label for="exampleInputEmail1" class="form-label h4">Jugador <?php echo $i; ?></label>
                    <select class="form-select text-capitalize" aria-label="Default select example" name="team_B_player<?php echo $i; ?>">
                        <option value="">Jugador</option>
                        <?php foreach ($players as $player) { ?>
                            <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['apellido'] . ', ' . $player['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="d-none d-lg-block col-lg-1"></div>
        </div>
        <div class="row border border-light p-3 mb-2 rounded">
            <div class="text-center h3 text-warning">Equipo "C"</div>
            <div class="d-none d-lg-block col-lg-1"></div>
            <?php for ($i = 1; $i < 3; $i++) { ?>
                <div class="col-md-6 col-lg-5">
                    <label for="exampleInputEmail1" class="form-label h4">Jugador <?php echo $i; ?></label>
                    <select class="form-select text-capitalize" aria-label="Default select example" name="team_C_player<?php echo $i; ?>">
                        <option value="">Jugador</option>
                        <?php foreach ($players as $player) { ?>
                            <option value="<?php echo $player['id']; ?>" class="text-capitalize"><?php echo $player['apellido'] . ', ' . $player['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="d-none d-lg-block col-lg-1"></div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 fs-4 fw-bold py-1">Actualizar datos</button>
    </div>
</form>

<?php include_once 'layout/footer.php'; ?>