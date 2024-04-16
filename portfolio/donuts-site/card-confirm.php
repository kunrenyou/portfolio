<?php require './includes/header.php';
?>

<?php
const PSTART = '<p class="border-left">';
const PALERT = '<p class="border-left alert">';
const PEND = '</p>';
$check = true;
echo '<section class="card card-confirm">';
echo '<h2>ご入力内容の確認</h2>';
echo '<p>お名前</p>';

if (isset($_REQUEST['name'])) {
  if (preg_match('/^[a-zA-Z]+$/', $_REQUEST['name'])) {
    echo '<p class="border-left">' . htmlspecialchars($_REQUEST['name']) . '</p>';
  } else {
    echo PALERT . '適切なお名前を入力してください' . PEND;
    $check = false;
  }
}
echo '<p>カード会社</p>';
if (isset($_REQUEST['cardcompany'])) {
  echo '<p class="border-left">' . htmlspecialchars($_REQUEST['cardcompany']) . '</p>';
}
echo '<p>カード番号</p>';
if (isset($_REQUEST['cardnumber'])) {
  $str = $_REQUEST['cardnumber'];
  if (preg_match('/^[0-9]{16}\z/', $str)) {
    echo '<p class="border-left">' . htmlspecialchars($_REQUEST['cardnumber']) . '</p>';
  } else {
    echo PALERT . '適切なカード番号を入力してください。' . PEND;
    $check = false;
  }
}

echo '<p>有効期限</p>';
if (isset($_REQUEST['year']) && isset($_REQUEST['month'])) {
  $str = $_REQUEST['year'];
  if (preg_match('/^([0-9]{2})\z/', $str, $matches)) {
    $year = htmlspecialchars($_REQUEST['year']);
    $str = $_REQUEST['month'];
    if (preg_match('/^([0-9]{2})\z/', $str, $matches)) {
      $month = htmlspecialchars($_REQUEST['month']);
      echo '<p class="border-left">' . $month . '/' . $year . '</p>';
    } else {
      echo PALERT . '年月が適切ではありません' . PEND;
      $check = false;
    }
  } else {
    echo PALERT . '年月が適切ではありません' . PEND;
    $check = false;
  }
}
echo '<p>セキュリティーコード</p>';
if (isset($_REQUEST['security'])) {
  $str = $_REQUEST['security'];
  if (preg_match('/^[0-9]{3,4}\z/', $str)) {
    $secCode = $_REQUEST['security'];
    $rep = strlen($secCode);
    echo '<p class="border-left">';
    for ($i = 0; $i < $rep; $i++) {
      echo '●';
    }
    echo '</p>';
  } else {
    echo PALERT . 'セキュリティコードが適切ではありません' . PEND;
    $check = false;
  }
}
if ($check) {
  echo '<form action="card-complete.php" method="post">';
} else {
  echo '<form action="card-input.php" method="post">';
}
echo '<input type="hidden" name="name" value="', $_REQUEST['name'], '">';
echo '<input type="hidden" name="cardcompany" value="', $_REQUEST['cardcompany'], '">';
echo '<input type="hidden" name="cardnumber" value="', $_REQUEST['cardnumber'], '">';
echo '<input type="hidden" name="year" value="', $_REQUEST['year'], '">';
echo '<input type="hidden" name="month" value="', $_REQUEST['month'], '">';
echo '<input type="hidden" name="security" value="', $_REQUEST['security'], '">';
if ($check) {
  echo '<input type="submit" class="button" value="この内容で登録する"> ';
} else {
  echo '<input type="submit" class="button" value="内容を修正する"> ';
}
echo '</form>';

?>
</section>
</body>
<?php require './includes/footer.php'; ?>