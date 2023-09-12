<style>
table{
  border:1px solid black;
  border-collapse: collapse;
  margin:10px;
}
td{
  border:1px solid black;
  padding:5px;
}
</style>

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
  echo '<form action="?page=change_psw" method="post">';
  echo '<input type="hidden" name="login" value="'.$un_admin['login'].'">';
  echo $un_admin['login'];
  echo '</td><td>';
  $time = new DateTime($un_admin['last_login']);

  echo $time->format('d/m/Y');
  echo ' ';
  echo $time->format('H:m');
  echo '</td><td>';
  echo '<input type="password" name="psw"></input>';
  echo '</td><td>';
  echo '<input type="submit" />';
  echo '</form>';
  echo '</td></tr>';
}




?>
</div><!-- container -->
