<?php
session_start();
$logoutMessage = '';
if (isset($_SESSION['customer'])) {
  // ログアウト時カスタマー,お気に入り,カートのセッションを開放します
  unset($_SESSION['customer']);
  unset($_SESSION['favorite']);
  unset($_SESSION['product']);
  $logoutMessage = 'ログアウトが完了しました';
} else {
  $logoutMessage = '既にログアウトしています';
}
session_write_close();
require './includes/header.php';
?>
<section class="login-out">
  <h2>ログアウト完了</h2>
  <div class="box-border">
    <p class="text-center m-24"><?php echo $logoutMessage; ?></p>
  </div>
  <p class="link"><a href="./index.php">TOPページへ戻る。</a></p>
</section>
</body>
<?php require './includes/footer.php'; ?>