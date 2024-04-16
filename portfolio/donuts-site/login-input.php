<?php require './includes/header.php'; ?>

<section class="login-out">

  <h2>ログイン</h2>
  <div class="box-border">
    <form action="login-complete.php" method="post">
      <p>メールアドレス</p><input type="text" name="mail" class="login-out-form">
      <p>パスワード</p><input type="password" name="password" class="login-out-form">
      <input type="submit" name="submit" class="button login-out-button" value="ログインする">
    </form>
  </div>
  <p class="link"><a href="customer-input.php">会員登録がお済みでない方はこちら<a></p>

</section>
</body>

<?php require './includes/footer.php'; ?>