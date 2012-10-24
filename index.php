<? require('header.php') ?>
  <div class="container-fluid">
    <h1>Login</h1>
    
    <form action="main.php" method="post">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" />

      <br />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" />

      <input type="submit" value="Login" />
    </form>
  </div>
<? require('header.php') ?>
