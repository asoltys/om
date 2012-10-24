<? require('header.php') ?>
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
