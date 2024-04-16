<?php require './includes/header.php';
if (isset($_SESSION['customer']) && isset($_SESSION['product'])) {
    // purchaseのidに使用するuniqueなキーを生成
    $sql = $pdo->query('SELECT MAX(id) FROM purchase');
    $currentId = $sql->fetch();
    $genelatedPurchaseId = $currentId[0] + 1;
    // purchaseテーブルに挿入
    $sql = $pdo->prepare('INSERT INTO purchase VALUES(?,?)');
    $sql->execute([$genelatedPurchaseId, $_SESSION['customer']['id']]);
    // purchase_detailテーブルにproductごとにデータを挿入
    foreach ($_SESSION['product'] as $key => $value) {
        $sql = $pdo->prepare('INSERT INTO purchase_detail VALUES(?,?,?)');
        $sql->execute([$genelatedPurchaseId, $key, $value['count']]);
    }
    // セッションからカート情報を削除
    unset($_SESSION['product']);
}
?>
<!-- HTMLを出力 -->
<section class="purchase purchase-complete">
    <h2 class="subpage-h2">ご購入完了</h2>
    <div class="box-border">
        <p>ご購入が完了しました</p>
        <p>今後ともご愛顧のほど、よろしくお願いします。</p>
    </div>
    <a href="index.php">
        <p class="link">TOPページへ戻る</p>
    </a>
</section>


<?php require './includes/footer.php'; ?>