<script>
$("#dl_button").click(function(){

    $.ajax({
       url : './ajax/clic_dl.php',
       type : 'GET', 
       data : 'mode=<?php echo $mode; ?>&id=<?php echo $_GET['id']; ?>', // On fait passer nos variables, exactement comme en GET, au script more_com.php
       dataType : 'html'
    });

});

</script>
