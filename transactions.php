<? require('connect.php') ?>
<?
  $result = mysql_query("
    SELECT amount, balance, created, with_account, description
    FROM om_repo 
    WHERE trading_account = '" . mysql_escape_string($_GET['trading_account']) . "'
    AND currency = '" . mysql_escape_string($_GET['currency']) . "'
    ORDER BY created DESC");

  while($row = mysql_fetch_array($result)) {
    $t->transactions[] = array(
      'date'=> date('j M', strtotime($row['created'])), 
      'description'=> $row['description'],
      'to'=> $row['with_account'],
      'amount'=> -$row['amount'], 
      'balance'=> $row['balance']
    );
  }

  echo json_encode($t);
?>
