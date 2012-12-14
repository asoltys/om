<? require('header.php') ?>
  <div class="container-fluid">
    <h1>Login</h1>

    <? if(isset($_SESSION['fail'])) { ?>
    <div class="fail">Login failed</div>
    <? } else if(isset($_SESSION['account'])) {
      header("Location: main.php"); 
    } ?>
    
    <form action="login.php" method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" />

      <br />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" />

      <br />

      <input type="submit" value="Login" />
    </form>
    <a href="http://openmoney.ca/om.cgi?p=requestLoginInfo">Forgot Password</a>
  </div>
<? require('header.php') ?>
