<? require('connect.php') ?>
<?
  $query = "SELECT id FROM om_repo";

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
      ,0)) + 
      IF @transaction_id LIKE '%-r'
        -abs(amount)
      ELSE
        abs(amount)
      END IF;

      UPDATE om_repo SET 
        balance = @balance, 
        trading = @trading
      WHERE id = " . $row['id'] . ";";
      
      echo "Updated record #" . $row['id'] . "<br />";
    }
    $db->multi_query($query);
  }
?>
