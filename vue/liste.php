

<div class="container">
  <table id="liste" class="display" style="width:100%">
    <thead>
      <tr>
        <th>Date</th>
        <th>Position</th>
        <th>Office</th>
        <th>Extn.</th>
        <th>Start date</th>
        <th>Salary</th>
      </tr>
    </thead>
  </table>
</div>

<script>
$(document).ready(function() {
  $('#liste').DataTable( {
    "url" :"./mdl/load_carnet_ajax.php",
    "type": "POST",
    "data": <?php echo $ajax_req ?>
  } );
} );

</script>
