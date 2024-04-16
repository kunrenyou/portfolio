<?php
require './includes/header.php';
?>
<section class="card card-complete">
  <h2>カード情報登録完了</h2>
  <div class="box-border">
    <?php
    if (isset($_SESSION['customer'])) {
      $id = $_SESSION['customer']['id'];
      $sql = $pdo->prepare('select * from card where id=?');
      $sql->execute([$id]);
      if ($_POST) {
        if (empty($sql->fetchAll())) {
          $sql = $pdo->prepare('insert into card values(?,?,?,?,?,?,?)');
          $sql->execute([
            $id,
            $_REQUEST['name'],
            $_REQUEST['cardcompany'],
            $_REQUEST['cardnumber'],
            $_REQUEST['month'],
            $_REQUEST['year'],
            $_REQUEST['security']
          ]);
          echo '<p>クレジットカード情報を登録しました</p>';
        } else {
          $sql = $pdo->prepare(
            'update card set card_name=?,card_type=?,card_no=?,card_month=?,card_year=?,card_security_code=?	where id=?'
          );
          $sql->execute([
            $_REQUEST['name'],
            $_REQUEST['cardcompany'],
            $_REQUEST['cardnumber'],
            $_REQUEST['month'],
            $_REQUEST['year'],
            $_REQUEST['security'],
            $id
          ]);
          echo '<p>クレジットカード情報を変更しました</p>';
        }
      }
    }
    ?>
    <a href="purchase-confirm.php">
      <p class="link">購入手続きを続ける</p>
    </a>
  </div>
</section>
</body>
<?php require './includes/footer.php'; ?>