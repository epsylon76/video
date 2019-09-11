<div class="container">
<table>
  <thead>
  <th>login</th>
  <th>derniere connexion</th>
  <th>nouveau mot de passe</th>
  <th>valider</th>
</thead>
<?php

foreach($liste_admins as $un_admin){
  echo '<tr>';
  echo '<td>';
  echo $un_admin['login'];
  echo '</td><td>';
  $time = new DateTime($un_admin['last_login']);

  echo $time->format('d/m/Y');
  echo ' ';
  echo $time->format('H:m');
  echo '</td><td>';
  echo '<input type="text" name="psw"></input>';
  echo '</td><td>';
  echo '<input type="submit" />';
  echo '</td></tr>';
}




?>
</div><!-- container -->
