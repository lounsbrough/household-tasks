<?php

$pageTitle = "Login";

define('DIR_PATH', '');

require dirname(__FILE__).'/includes/header.php';

?>

<form id="login-form">
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php

$footerContent = '
    <script src="'.DIR_PATH.'js/login.js"></script>
';

require dirname(__FILE__)."/includes/footer.php";

?>