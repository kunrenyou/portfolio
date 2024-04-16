<?php
require './includes/header.php';
?>
<section class="customer customer-complete">

  <h2 class="customer-h2">会員登録完了</h2>
  <div class="box-border">
    <?php
    if ($_REQUEST) {
      // ログインしているかしていないかで処理を変える
      if (isset($_SESSION['customer'])) {
        // ログインしているとき、ＩＤをキーにしてデータベースから情報を取得する
        $id = $_SESSION['customer']['id'];
        // 同じメールアドレスでほかの人が登録していないか確認する
        $sql = $pdo->prepare('select * from customer where id!=? and mail=?');
        $sql->execute([$id, $_REQUEST['mail']]);
      } else {
        // ログインしていないときはメールアドレスが重複しているかどうかデータベースを照合
        $sql = $pdo->prepare('select * from customer where mail=?');
        $sql->execute([$_REQUEST['mail']]);
      }
      // 重複していないときの処理
      if (empty($sql->fetchAll())) {
        // ログインしている場合はデータベース登録情報のアップデート
        if (isset($_SESSION['customer'])) {
          $sql = $pdo->prepare('update customer set name=?, kana=?,post_code=?,address=?,mail=?,password=? where id=?');
          $sql->execute([$_REQUEST['name'], $_REQUEST['kana'], $_REQUEST['post_code'], $_REQUEST['address'], $_REQUEST['mail'], $_REQUEST['password'], $id]);
          $_SESSION['customer'] = [
            'id' => $id, 'name' => $_REQUEST['name'], 'kana' => $_REQUEST['kana'], 'post_code' => $_REQUEST['post_code'], 'adress' => $_REQUEST['adress'], 'mail' => $_REQUEST['mail'], 'password' => $_REQUEST['password']
          ];
          $_SESSION['customer'] = [
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'kana' => $_POST['kana'],
            'post-code' => $_POST['post_code'],
            'address' => $_POST['address'],
            'mail' => $_POST['mail'],
            'password' => $_POST['password']
          ];
          echo '<p class="text-center">お客さま情報を更新しました。</p>';
        } else {
          // ログインしていない方のデータの新規登録
          $sql = $pdo->prepare('insert into customer values(null,?,?,?,?,?,?)');
          $sql->execute([
            $_REQUEST['name'], $_REQUEST['kana'], $_REQUEST['post_code'], $_REQUEST['address'], $_REQUEST['mail'], $_REQUEST['password']
          ]);
          echo '<p class="text-center">会員登録が完了しました。</p>';
          echo '<a href="login-input.php"><p class="link">ログイン画面へ進む</p></a>';
        }
      } else {
        echo '<p class="text-center">メールアドレスの重複があるため登録できませんでした。</p>';
        echo '<a href="customer-input.php"><p class="link">情報入力画面へ戻る</p></a>';
      }
    }
    ?>
  </div>
</section>



<?php require './includes/footer.php'; ?>