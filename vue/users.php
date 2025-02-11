<style>
table{
  border:1px solid black;
  border-collapse: collapse;
  margin: 10px auto;
}
td{
  border:1px solid black;
  padding:5px;
}

.container{
  margin: 0 auto; 
    text-align: center;
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
  echo '<form action="/actions/changePsw" method="post">';
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
  echo '<button type="submit">Valider</button>';
  echo '</form>';
  echo '</td></tr>';
}

echo '</table>';


?>

<form action="/actions/addUser" method="post">
  <table style="margin-top: 50px;">
    <tr>
        <td>login:</td>
        <td><input type="text" name="new_login" required="required"></td>
    </tr>
    <tr>
        <td>mot de passe:</td>
        <td><input type="password" name="new_password" required="required"></td>
    </tr>
  </table>
  <button class="btn btn-secondary" style="font-size: 14px;" type="submit">
      Ajouter utilisateur
  </button>
</form>


</div><!-- container -->
