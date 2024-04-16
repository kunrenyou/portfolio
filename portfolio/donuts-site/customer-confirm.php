<?php require './includes/header.php';
?>

<section class="customer">
  <h2 class="customer-h2">ご入力内容の確認</h2>
  <?php
  const PSTART = '<p class="border-left">';
  const PALERT = '<p class="border-left alert">';
  const PEND = '</p>';
  $check = true;
  echo '<p>お名前</p>';
  if (isset($_REQUEST['name'])) {
    echo PSTART . htmlspecialchars($_REQUEST['name']) . PEND;
  }
  echo '<p>お名前（フリガナ）</p>';
  if (isset($_REQUEST['kana'])) {
    echo PSTART . htmlspecialchars($_REQUEST['kana']) . PEND;
  }
  echo '<p>郵便番号</p>';
  $post_code = '';
  if (isset($_REQUEST['post_code'])) {
    $post_code = $_REQUEST['post_code'];
  }
  if (preg_match('/^[0-9]{7}$/', $post_code)) {
    echo PSTART . $post_code . PEND;
  } else {
    $check = false;
    echo PALERT . '適切な7桁の郵便番号を入れてください。' . PEND;
  }

  // echo htmlspecialchars($_REQUEST['post_code']);

  echo '<p>住所</p>';
  if (isset($_REQUEST['address'])) {
    echo PSTART . htmlspecialchars($_REQUEST['address']) . PEND;
  }
  echo '<p>メールアドレス</p>';
  if (isset($_REQUEST['mail'])) {
    echo PSTART, htmlspecialchars($_REQUEST['mail']), PEND;
  }
  echo '<p>パスワード</p>';
  $password = '';
  if (isset($_REQUEST['password'])) {
    $password = $_REQUEST['password'];
    $str = strlen($password);
    $hidepass = '';

    for ($i = 0; $i < $str; $i++) {
      $hidepass .= '・';
    }
  }
  if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{8,}$/', $password)) {
    echo PSTART, $hidepass, PEND;
  } else {
    $check = false;
    echo PALERT, 'パスワード「', $hidepass, '」は適切ではありません。', PEND;
  }
  if ($check) {
    echo '<form action="customer-complete.php" method="post">';
  } else {
    echo '<form action="customer-input.php" method="post">';
  }
  echo '<input type="hidden" name="name" value="', $_REQUEST['name'], '">';
  echo '<input type="hidden" name="kana" value="', $_REQUEST['kana'], '">';
  echo '<input type="hidden" name="post_code" value="', $_REQUEST['post_code'], '">';
  echo '<input type="hidden" name="mail" value="', $_REQUEST['mail'], '">';
  echo '<input type="hidden" name="address" value="', $_REQUEST['address'], '">';
  echo '<input type="hidden" name="password" value="', $_REQUEST['password'], '">';
  if ($check) {
    echo '<input type="submit" class="button" value="この内容で登録する"> ';
  } else {
    echo '<input type="submit" class="button" value="内容を修正する"> ';
  }


  echo '</form>';

  ?>
</section>

<?php require './includes/footer.php'; ?>