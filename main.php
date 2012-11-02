<? require('header.php') ?>
  <script src="js/report.js"></script>
  <h1>Open Money</h1>
  <form action="send_transaction.php">
    <input type="hidden" id="trading_account" value="<? echo $_SESSION['account'] ?>" />
    <label for="amount">Pay To</label>
    <input type="text" id="amount" name="amount" placeholder="<account ID>" />

    <br />

    <label for="amount">Amount</label>
    <input type="text" id="amount" name="amount" />
  </form>

  <h2>Transactions</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Date</th>
        <th>To</th>
        <th>Credit</th>
        <th>Debit</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>

  <a href="logout.php">Logout</a>
<? require('footer.php') ?>
