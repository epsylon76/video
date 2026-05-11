<div class="container">
    <div class="row">
        <h1> Création des captures photos </h1>
    </div>
    <form action="/actions/do_captures" method="post">
        <?php
         if(!is_executable('scripts/captures.sh')){
            echo '<h1 style="color:red;">Script non executable !</h1>';
        }

        foreach ($video_array as $key => $vid) {
            $urlvid = chemin_relatif_normalise(substr($vid, strlen(realpath($data))));
        ?>
            <div class="row">
                <h5><?php echo $key + 1; ?>. <?php echo htmlspecialchars($urlvid, ENT_QUOTES, 'UTF-8'); ?></h5>
            </div>

        <?php } ?>

        <input type="hidden" name="file" value="<?php echo htmlspecialchars($vid ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="retour" value="<?php echo htmlspecialchars(dirname($chemin), ENT_QUOTES, 'UTF-8'); ?>">
        <div class="row" style="border:3px solid red; padding:10px;">

            <div class="col-3">
                <label>Nombre de photos par secondes</label>
                <input class="form-control" name="cadence" type="number" min="1" max="4" value="1">
            </div>
            <div class="col-3">
                <label>&nbsp;</label><br>
                <input type="submit" class="btn btn-success" value="valider">
            </div>
        </div>
    </form>

</div>
