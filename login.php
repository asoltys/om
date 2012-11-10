<? require('connect.php') ?>
<?
  $result = $db->query("
    SELECT DISTINCT user_member_currencies.account
    FROM account
    JOIN user_member_currencies
    ON user_member_currencies.user_id = account.id
    WHERE account.name = '" . mysql_escape_string($_POST["username"]) . "'
    AND account.password = '" . mysql_escape_string($_POST["password"]) . "'" );

  if ($result->num_rows == 0) { 
    $_SESSION['fail'] = 1;
    header("Location: index.php");
  } else {
    $row = $result->fetch_assoc();
    $_SESSION['account'] = $row['account'];
    header("Location: main.php");
  }
?>
