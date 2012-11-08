<? require('connect.php') ?>
<?
  $result = mysql_query("
    SELECT DISTINCT user_member_currencies.account
    FROM account
    JOIN user_member_currencies
    ON user_member_currencies.user_id = account.id
    WHERE account.name = '" . mysql_escape_string($_POST["username"]) . "'
    AND account.password = '" . mysql_escape_string($_POST["password"]) . "'" );

  if (mysql_num_rows($result) == 0) { 
    $_SESSION['fail'] = 1;
    header("Location: index.php");
  } else {
    $row = mysql_fetch_array($result);
    $_SESSION['account'] = $row['account'];
    header("Location: main.php");
  }
?>
