<?php require './includes/header.php'; ?>
<?php

$id = $name = $kana = $post_code = $address = $mail = $password = '';
if (isset($_SESSION['customer'])) {
  $id = $_SESSION['customer']['id'];
  $name = $_SESSION['customer']['name'];
  $kana = $_SESSION['customer']['kana'];
  $post_code = $_SESSION['customer']['post_code'];
  $address = $_SESSION['customer']['address'];
  $mail = $_SESSION['customer']['mail'];
  $password = $_SESSION['customer']['password'];
}
if ($_POST) {
  $name = $_POST['name'];
  $kana = $_POST['kana'];
  $post_code = $_POST['post_code'];
  $address = $_POST['address'];
  $mail = $_POST['mail'];
  $password = $_POST['password'];
}
echo '<section class="customer">';
echo '<h2 class="customer-h2">会員登録</h2>';
echo '<form action="customer-confirm.php" method="post" class="customer-form">';
echo '<p>お名前<span>（必須）</span></p>';
echo '<input type="text" name="name" value="', $name, '" required></input>';
echo '<p>お名前（フリガナ）<span>（必須）</span></p>';
echo '<input type="text" name="kana" value="' . $kana . '" required></input>';
echo '<p>郵便番号<span>（必須）</span></p>';
echo '<input type="text" name="post_code" value="' . $post_code . '" class="zipcode" required></input>';
echo '<p>住所<span>（必須）</span></p>';
echo '<input type="text" name="address" value="' . $address . '" required></input>';
echo '<p>メールアドレス<span>（必須）</span></p>';
echo '<input type="email" name="mail" value="' . $mail . '" required></input>';
echo '<p>パスワード<span>（必須）</span></p>';
echo '<p><small>A-Z,a-z,0-9を少なくとも1つは含めて8文字以上で入力してください。</small></p>';
echo '<input type="text" name="password" value="' . $password . '" required></input>';
echo '<input type="submit" class="button" value="ご入力内容を確認する"> ';
?>
</form>
</section>

<?php require './includes/footer.php'; ?>