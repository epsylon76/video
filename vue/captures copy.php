<div class="container">
    <div class="row">
        <h1> Création des captures photos </h1>
    </div>

    <?php
    foreach ($video_array as $key => $vid) {
        $urlvid = str_replace($data, '', $vid);
    ?>
        <div class="row">
            <h4><?php echo $key+1;?>. <?php echo $urlvid;?></h4>
            <div class="col-5 embed-responsive embed-responsive-16by9" style="border:3px solid red;margin:10px;margin:0 auto;">
                <video controls muted id="vid_<?php echo $key; ?>" class="embed-responsive-item video-js" preload="metadata">
                    <source src="/data/<?php echo $urlvid; ?>">
                </video>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <form action="/actions/do_captures" method="post">
                    <input type="hidden" name="file_<?php echo $key; ?>" value="<?php echo $vid; ?>">
                    <div id="store_a_<?php echo $key; ?>" class="btn btn-lg btn-info store" name="store_a_<?php echo $key; ?>" value="0" data-key="<?php echo $key; ?>" data-letter="a">A <span></span></div>
                    <div id="store_b_<?php echo $key; ?>" class="btn btn-lg btn-info store" name="store_b_<?php echo $key; ?>" value="0" data-key="<?php echo $key; ?>" data-letter="b">B <span></span></div>
                    <input id="input_store_a_<?php echo $key; ?>" type="hidden" name="store_a_<?php echo $key; ?>" value="0"/>
                    <input id="input_store_b_<?php echo $key; ?>" type="hidden" name="store_b_<?php echo $key; ?>" value="0"/>
                </form>
            </div>
        </div>
<!--
        <script>
            // Get the audio element with id="my_video_1"
            var aud_ = document.getElementById("vid_");

            // Assign an ontimeupdate event to the audio element, and execute a function if the current playback position has changed
            aud_.ontimeupdate = function() {
                document.getElementById("timestamp_").innerHTML = aud_.currentTime;
            };   
        </script>
    -->
    <?php } ?>


</div>

<script>

    //enregistrer les positions
    $('.store').click(function() {
        k = $(this).data('key');
        l = $(this).data('letter');
        
        var tms = $("#vid_"+k).prop('currentTime');
        console.log(tms);

        $(this).find('span').text(' -> '+tms);
 
    });
</script>