<? require('header.php') ?>
<?
  $con = mysql_connect("localhost","root","MPJzfq97");
  if (!$con) {
    die('Could not connect: ' . mysql_error());
  }
  mysql_select_db("alpha", $con);
  $result = mysql_query("
    SELECT DISTINCT user_member_currencies.account
    FROM account
    JOIN user_member_currencies
    ON user_member_currencies.user_id = account.id
    WHERE account.name = '" . $_POST["username"] . "'
    AND account.password = '" . $_POST["password"] . "'" );
  $account = "";

  if (mysql_num_rows($result) == 0) { echo 'Fail'; }

  while($row = mysql_fetch_array($result)) {
    $account = $row['account'];
  }

  mysql_close($con);
?>
  <h1>Open Money</h1>
  <form action="send_transaction.php">
    <label for="amount">Pay To</label>
    <input type="text" id="amount" name="amount" value="<account ID>" />

    <br />

    <label for="amount">Amount</label>
    <input type="text" id="amount" name="amount" />
  </form>

  <h2>Transactions</h2>
  <table>
    <tr>
      <th>Date</th>
      <th>To</th>
      <th>Amount</th>
      <th>Date</th>
    </tr>
  </table>
<? require('footer.php') ?>
