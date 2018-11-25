<script>
$("#dl_button").click(function(){

    $.ajax({
       url : './ajax/clic_dl.php',
       type : 'GET',
       data : 'chemin=<?php echo $chemin; ?>&email=<?php echo $email ?>', // On fait passer nos variables, exactement comme en GET, au script more_com.php
       dataType : 'html'
    });

});

</script>
