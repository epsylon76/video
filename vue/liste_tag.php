<div class="container">
<h3 style="margin-bottom:15px;" >Tags</h3>

<?php


foreach($liste_tag as $tag){
    echo '<li class="list-group-item">'; 
    echo '<a href="/admin/tags/'. urlencode($tag['nom_tag']) . '">'.$tag['nom_tag'] . '</a>';
    echo '<span class="badge badge-info" style="margin-left:10px;">'.$tag['occurrences'].'</span>';
    echo '</li>';
}

?>

</div>