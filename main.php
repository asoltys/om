<? require('header.php') ?>
  <script src="js/report.js"></script>
  <h1>Open Money</h1>

  <form action="send_transaction.php" method="post">
    <input type="hidden" id="current_account" value="<? echo $_SESSION['account'] ?>" />
    <input type="hidden" id="current_currency" value="<? echo $_SESSION['currency'] ?>" />

    <div style="float: left; margin-right: 10px">
      <label for="account">Account</label>
      <select id="account" name="account">
      </select>
    </div>

    <div>
      <label for="currency">Currency</label>
      <select id="currency" name="currency">
      </select>
    </div>

    <h2>Transactions</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>To</th>
          <th>Amount</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <td><? echo date("j\&\\n\b\s\p;M"); ?></td>
            <td><input type="text" id="description" name="description" placeholder="<description>" /></td>
            <td><input type="text" id="with_account" name="with_account" placeholder="<account id>" /></td>
            <td><input type="text" id="amount" name="amount" placeholder="0.00" /></td>
            <td></td>
        </tr>
      </tbody>
    </table>

    <input type="submit" value="GO" />
  </form>

  <a href="logout.php">Logout</a>
<? require('footer.php') ?>
