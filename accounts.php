<? require('connect.php') ?>
<?
  $result = $db->query("
    SELECT DISTINCT account
    FROM user_member_currencies 
    WHERE user_id = " . $_SESSION['user_id']);

  while($row = $result->fetch_assoc()) {
    $t->accounts[] = array(
      'account'=> $row['account']
    );
  }

  echo json_encode($t);
?>
