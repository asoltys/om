<? require('connect.php') ?>
<?
  if (!is_numeric($_POST['amount']) || $_POST['amount'] < 0) {
    $_SESSION['flash'] = 'Must enter a positive amount';
    header("Location: main.php");
  } else {
    $query = "
    SET @user_id1 = (SELECT user_id 
      FROM user_member_currencies 
      WHERE account = '" . mysql_escape_string($_SESSION['account']) . "' 
      AND currency = '" . mysql_escape_string($_POST['currency']) . "' 
      ORDER BY id DESC LIMIT 1);

    SET @user_id2 = (SELECT user_id 
      FROM user_member_currencies 
      WHERE account = '" . mysql_escape_string($_POST['with_account']) . "' 
      AND currency = '" . mysql_escape_string($_POST['currency']) . "' 
      ORDER BY id DESC LIMIT 1);

    SET @bal1 = (SELECT COALESCE((
      SELECT balance 
      FROM om_repo 
      WHERE trading_account = '" . mysql_escape_string($_SESSION['account']) . "' 
      AND currency = '" . mysql_escape_string($_POST['currency']) . "' 
      ORDER BY id DESC LIMIT 1)
    ,0));

    SET @bal2 = (SELECT COALESCE((SELECT balance FROM om_repo WHERE trading_account = '" . mysql_escape_string($_SESSION['account']) . "' AND currency = '" . mysql_escape_string($_POST['currency']) . "' ORDER BY id DESC LIMIT 1),0));

    SET @transaction_id = (SELECT COALESCE((SELECT CAST(MAX(transaction_id) AS SIGNED) + 1 FROM om_repo WHERE transaction_id LIKE '23__________'), 230000000000));

    SET @id1 = (SELECT MAX(id) + 1 FROM om_repo);
    SET @id2 = (SELECT MAX(id) + 2 FROM om_repo);

    INSERT INTO om_repo (
      id,
      transaction_id, 
      user_id, 
      created, 
      trading_account,
      currency,
      description,
      with_account,
      amount,
      balance,
      trading
    ) VALUES (
      @id1,
      @transaction_id,
      @user_id1,
      NOW(),
      '" . mysql_escape_string($_SESSION['account']) . "',
      '" . mysql_escape_string($_POST['currency']) . "',
      '" . mysql_escape_string($_POST['description']) . "',
      '" . mysql_escape_string($_POST['with_account']) . "',
      " . mysql_escape_string($_POST['amount']) . ",
      @bal1 - " . mysql_escape_string($_POST['amount']) . ",
      " . mysql_escape_string($_POST['amount']) . " * 2
    );

    INSERT INTO om_repo (
      id,
      transaction_id, 
      user_id, 
      created, 
      trading_account,
      currency,
      description,
      with_account,
      amount,
      balance,
      trading
    ) VALUES (
      @id2,
      @transaction_id,
      @user_id2,
      NOW(),
      '" . mysql_escape_string($_POST['with_account']) . "',
      '" . mysql_escape_string($_POST['currency']) . "',
      '" . mysql_escape_string($_POST['description']) . "',
      '" . mysql_escape_string($_SESSION['account']) . "',
      '" . mysql_escape_string($_POST['amount']) . "',
      @bal2 + " . mysql_escape_string($_POST['amount']) . ",
      " . mysql_escape_string($_POST['amount']) . " * 2
    );";

    $db->multi_query($query);
    header("Location: main.php");
  }
?>
