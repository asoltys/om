<? require('header.php') ?>
  <script src="js/report.js"></script>

  <div id="logout">
    <span><? echo $_SESSION['account'] ?></span> |
    <a href="http://openmoney.ca/om.cgi">Settings</a> |
    <a href="logout.php">Logout</a>
  </div>

  <h1 style="margin-top: -10px;">open money</h1>

  <? if (isset($_SESSION['flash'])) {
    echo '<div class="alert alert-error">' . $_SESSION['flash'] . '</div>';
    unset($_SESSION['flash']);
  } ?>

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

    <table class="table transactions">
      <tbody>
        <tr>
            <td><input type="text" id="description" name="description" readonly="readonly" value="<? echo date("j\&\\n\b\s\p;M"); ?>" /></td>
            <td><input type="text" id="description" name="description" placeholder="<description>" /></td>
            <td><input type="text" id="with_account" name="with_account" placeholder="<account id>" /></td>
            <td><input type="text" id="amount" name="amount" placeholder="0.00" /></td>
            <td><input type="submit" value="send" /></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td>Date</td>
          <td>Description</td>
          <td>With</td>
          <td>Amount</td>
          <td>Balance</td>
        </tr>
      </tbody>
    </table>
  </form>

<? require('footer.php') ?>
