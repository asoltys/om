<? require('connect.php') ?>
<?
  if ($_GET['all']) {
    $query = "SELECT id FROM om_repo";
  } else {
    $query = "
      SELECT id FROM om_repo WHERE id > (SELECT max(id)
      FROM om_repo 
      WHERE flags = 'm')";
  }

  $db->real_query($query);
  $result = $db->store_result();
  if ($result) {
    $ids = array();
    while($row = $result->fetch_assoc()) {
      $ids[] = $row['id'];
    }
    $ids = json_encode($ids);
  }
?>
<? require('header.php') ?>
<script type="text/javascript">
  var ids = <? echo $ids; ?>;
  var i = 0;

  $(function() {
    if (i < ids.length)
      go();
  });

  function go() {
    $.get('update_balance_and_trading.php', { id: ids[i] }, function() {
      $('body').append(ids[i] + "<br>");
      i++;
      if (i < ids.length)
        go();
    });
  }
    
</script>
<? require('footer.php') ?>
