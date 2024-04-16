<?php require './includes/header.php'; ?>

<section class="login-out">
  <h2>ログアウト</h2>
  <div class="box-border">
    <form action="logout-complete.php" method="post">
      <p class="text-center mt-24">ログアウトしますか？</p>
      <input type="submit" name="submit" class="button login-out-button" value="ログアウトする">
    </form>
  </div>
</section>

<?php require './includes/footer.php'; ?>