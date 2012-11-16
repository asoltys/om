<? require('connect.php') ?>
<?
  $_SESSION['flash'] = "";

  $query = "
    SELECT user_id 
    FROM user_member_currencies 
    WHERE account = '" . mysql_escape_string($_SESSION['account']) . "' 
    AND currency = '" . mysql_escape_string($_SESSION['currency']) . "'";
  $result = $db->query($query);

  if ($result->num_rows == 0) {
    header("Location: logout.php");
  }

  $query = "
    SELECT user_id 
    FROM user_member_currencies 
    WHERE account = '" . mysql_escape_string($_POST['with_account']) . "' 
    AND currency = '" . mysql_escape_string($_SESSION['currency']) . "'
    AND account != '" . mysql_escape_string($_SESSION['account']) . "'";
  $result = $db->query($query);

  if ($result->num_rows == 0) {
    $_SESSION['flash'] .= 'Invalid account name<br />';
  }

  if (!is_numeric($_POST['amount']) || $_POST['amount'] < 0) {
    $_SESSION['flash'] .= 'Must enter a positive amount<br />';
  } 

  if ($_SESSION['flash'] == "") {
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

    SET @bal2 = (SELECT COALESCE((
      SELECT balance 
      FROM om_repo 
      WHERE trading_account = '" . mysql_escape_string($_POST['with_account']) . "' 
      AND currency = '" . mysql_escape_string($_POST['currency']) . "' 
      ORDER BY id DESC LIMIT 1)
    ,0));

    SET @trading1 = (SELECT COALESCE((
      SELECT trading 
      FROM om_repo 
      WHERE trading_account = '" . mysql_escape_string($_SESSION['account']) . "' 
      AND currency = '" . mysql_escape_string($_POST['currency']) . "' 
      ORDER BY id DESC LIMIT 1)
    ,0));

    SET @trading2 = (SELECT COALESCE((
      SELECT trading 
      FROM om_repo 
      WHERE trading_account = '" . mysql_escape_string($_POST['with_account']) . "' 
      AND currency = '" . mysql_escape_string($_POST['currency']) . "' 
      ORDER BY id DESC LIMIT 1)
    ,0));

    SET @transaction_id = (SELECT COALESCE((SELECT CAST(MAX(transaction_id) AS SIGNED) + 1 FROM om_repo WHERE transaction_id LIKE '23__________'), 230000000000));

    INSERT INTO om_repo (
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
      @transaction_id,
      @user_id1,
      NOW(),
      '" . mysql_escape_string($_SESSION['account']) . "',
      '" . mysql_escape_string($_POST['currency']) . "',
      '" . mysql_escape_string($_POST['description']) . "',
      '" . mysql_escape_string($_POST['with_account']) . "',
      -" . mysql_escape_string($_POST['amount']) . ",
      @bal1 - " . mysql_escape_string($_POST['amount']) . ",
      @trading1 + " . mysql_escape_string($_POST['amount']) . "
    );

    INSERT INTO om_repo (
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
      @transaction_id,
      @user_id2,
      NOW(),
      '" . mysql_escape_string($_POST['with_account']) . "',
      '" . mysql_escape_string($_POST['currency']) . "',
      '" . mysql_escape_string($_POST['description']) . "',
      '" . mysql_escape_string($_SESSION['account']) . "',
      " . mysql_escape_string($_POST['amount']) . ",
      @bal2 + " . mysql_escape_string($_POST['amount']) . ",
      @trading2 + " . mysql_escape_string($_POST['amount']) . "
    );";

    $db->multi_query($query);
    unset($_SESSION['flash']);
  }

  header("Location: main.php");
?>
