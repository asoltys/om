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
    $query = "";
    while($row = $result->fetch_assoc()) {
      $query .= "
      SELECT trading_account, currency, amount, transaction_id 
      FROM om_repo WHERE id = " . $row['id'] . " 
      INTO @trading_account, @currency, @amount, @transaction_id;

      
      SET @balance = (SELECT COALESCE((
        SELECT balance 
        FROM om_repo 
        WHERE trading_account = @trading_account 
        AND currency = @currency
        AND id <  " . $row['id'] . "
        ORDER BY id DESC LIMIT 1)
      ,0)) + @amount;

      SET @trading = (SELECT COALESCE((
        SELECT trading 
        FROM om_repo 
        WHERE trading_account = @trading_account 
        AND currency = @currency 
        AND id <  " . $row['id'] . "
        ORDER BY id DESC LIMIT 1)
      ,0)) + SELECT IF(@transaction_id LIKE '%-r', -abs(amount), abs(amount));

      UPDATE om_repo SET 
        balance = @balance, 
        trading = @trading,
        flags = 'm'
      WHERE id = " . $row['id'] . ";";
      
      echo "Updated record #" . $row['id'] . "<br />";
    }
    $db->multi_query($query);
  }
?>
