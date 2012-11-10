<? require('connect.php') ?>
<?
  $result = $db->query("
    SELECT DISTINCT 
      user_member_currencies.account, 
      user_member_currencies.user_id
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
    $_SESSION['user_id'] = $row['user_id'];
    header("Location: main.php");
  }
?>
