<?php
session_start();
require './includes/database.php';
$sql = $pdo->prepare('select * from customer where mail=? and password=?');
$sql->execute([$_REQUEST['mail'], $_REQUEST['password']]);
$userdata = $sql->fetchall();
foreach ($userdata as $row) {
  $_SESSION['customer'] = [
    'id' => $row['id'], 'name' => $row['name'], 'kana' => $row['kana'],
    'post_code' => $row['post_code'], 'address' => $row['address'], 'mail' => $row['mail'],
    'password' => $row['password']
  ];
}
session_write_close();
require 'includes/header.php'; ?>

<section class="login-out">
  <?php
  if (isset($_SESSION['customer'])) {
    echo '<h2>ログイン完了</h2>';
  } else {
    echo '<h2>ログインできませんでした</h2>';
  }
  ?>
  <div class="box-border">
    <?php
    if (isset($_SESSION['customer'])) {
      echo '<p class="m-24 text-center">ログインが完了しました。</p>';
    } else {
      echo '<p class="m-24 text-center">メールアドレスまたはパスワードが違います。</p>';
    }

    ?>
  </div>
  <p class="link"><a href="index.php">TOPページへ戻る<a></p>
</section>
</body>
<?php require './includes/footer.php'; ?>