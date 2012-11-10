<? require('connect.php') ?>
<?
  $result = $db->query("
    SELECT amount, balance, created, with_account, description
    FROM om_repo 
    WHERE trading_account = '" . mysql_escape_string($_GET['trading_account']) . "'
    AND currency = '" . mysql_escape_string($_GET['currency']) . "'
    ORDER BY created DESC");

  $_SESSION['currency'] = $_GET['currency'];

  $t->transactions = array();

  while($row = $result->fetch_assoc()) {
    $t->transactions[] = array(
      'date'=> date('j\&\\n\b\s\p;M', strtotime($row['created'])), 
      'description'=> $row['description'],
      'to'=> $row['with_account'],
      'amount'=> -$row['amount'], 
      'balance'=> $row['balance']
    );
  }

  echo json_encode($t);
?>
