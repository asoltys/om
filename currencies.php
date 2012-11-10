<? require('connect.php') ?>
<?
  $result = $db->query("
    SELECT DISTINCT currency 
    FROM user_member_currencies 
    WHERE user_id = " . $_SESSION['user_id'] . "
    AND account = '" . mysql_escape_string($_GET['account']) . "'");

  $_SESSION['account'] = $_GET['account'];

  while($row = $result->fetch_assoc()) {
    $t->currencies[] = array(
      'name'=> $row['currency']
    );
  }

  echo json_encode($t);
?>
