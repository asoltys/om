<? require('connect.php') ?>
<?
  $query = "
  SELECT trading_account, currency, amount, transaction_id 
  FROM om_repo WHERE id = " . $_GET['id'] . " 
  INTO @trading_account, @currency, @amount, @transaction_id;

  
  SET @balance = (SELECT COALESCE((
    SELECT balance 
    FROM om_repo 
    WHERE trading_account = @trading_account 
    AND currency = @currency
    AND id <  " . $_GET['id'] . "
    ORDER BY id DESC LIMIT 1)
  ,0)) + @amount;

  SET @trading = (SELECT COALESCE((
    SELECT trading 
    FROM om_repo 
    WHERE trading_account = @trading_account 
    AND currency = @currency 
    AND id <  " . $_GET['id'] . "
    ORDER BY id DESC LIMIT 1)
  ,0)) + 
  (SELECT IF(@transaction_id LIKE '%-r', 
    -abs(@amount), 
    abs(@amount))
  );

  UPDATE om_repo SET 
    balance = @balance, 
    trading = @trading,
    flags = 'm'
  WHERE id = " . $_GET['id'] . ";";
  $db->multi_query($query);
?>
