<?php include_once 'layout/header.php'; ?>

<form class="row bg-success fw-bold p-4 mb-5" action="add_match.php" method="POST">
    <input type="text" class="d-none" value="profesionalismo" name="age">
    <div class="col-12 border border-light rounded p-4 mb-3">
        <div class="text-warning h3 mb-3">Sistema de puntos</div>
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <label for="exampleInputEmail1" class="form-label h4">Puntos partido ganado</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="points_match">
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Puntos set ganado</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="points_set">
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Puntos final ganada</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="points_final_match">
            </div>
        </div>
        <div class="row">
            <div class="d-none d-lg-block col-lg-2"></div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Puntos semifinal ganada</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="points_semifinal_match">
            </div>
            <div class="col-sm-6 col-lg-4 mb-3">
                <label for="exampleInputEmail1" class="form-label h4">Puntos actuación destacada</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="outstanding_performance">
            </div>
            <div class="d-none d-lg-block col-lg-2"></div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-100 fs-4 fw-bold py-1">Guardar cambios</button>
    </div>
</form>


<?php include_once 'layout/footer.php'; ?>