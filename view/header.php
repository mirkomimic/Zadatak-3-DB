<header id="header">
  <div >
    <h3>
      <?php
        echo $user;
      ?>
    </h3>
  </div>
  <div>
    <form action="" method="POST">
      <input type="submit" value="Logout" name="logout">
    </form>
  </div>
</header>

<?php

if(isset($_POST['logout'])) {
  unset($_SESSION['logged_user']);
  // session_unset();
  // session_destroy();
  header("Location: .");
}

?>