<?php require './includes/header.php';
?>
<?php

$name = $cardnumber = $year = $month = '';
if ($_POST) {
  $name = $_POST['name'];
  $cardnumber = $_POST['cardnumber'];
  $year = $_POST['year'];
  $month = $_POST['month'];
}

echo '<section class="card">';
echo '<div class="title1">
  <h2>カード情報登録</h2>
</div>';
echo '<form action="card-confirm.php" method="post" class="card-form">';
echo '<p>お名前<span>（必須）</span></p>';
echo '<input type="text" name="name" value="' . $name . '" required></input>';
echo '<p>カード会社<span>（必須）</span></p>';
echo '<div class="row special"><label class="row"><input type="radio" name="cardcompany" value="JCB" class="radiobtn" required><p class="radio">JCB</p></label>';
echo '<label class="row"><input type="radio" name="cardcompany" value="Visa" class="radiobtn"><p class="radio">Visa</p></label>';
echo '<label class="row"><input type="radio" name="cardcompany" value="mastercard" class="radiobtn"><p class="radio">Mastercard</p></label></div>';
echo '<p>カード番号<span>（必須）</span></p>';
echo '<input type="text" name="cardnumber" value="' . $cardnumber . '" required>';
echo '<p>有効期限<span>（必須）</span></p>';
echo '<p class="mb-4"><input type="text"  name="year" class="short-input mb-4" value="' . $year . '" required>年</p>';
echo '<p class="mb-20"><input type="text" name="month" class="short-input mb-4" value="' . $month . '" required>月</p>';
echo '<p>セキュリティーキー<span>（必須）</span></p>';
echo '<input type="password"  required name="security" class="short-input">';
echo '<input type="submit" class="button" value="この内容で登録する"> ';
echo '</form>';
?>
</section>
<?php require './includes/footer.php'; ?>