<?php require './includes/header.php';
?>
<?php
$checker = true;
echo '<section class="purchase purchase-confirm"><h2 class="subpage-h2">ご購入確認</h2>';
// お気に入り画面のまとめて購入ボタンから飛んできたとき限定でPOSTでカートに追加
if ($_POST) {
    foreach ($_POST as $id => $value) {
        if (isset($_SESSION['product'][$id])) {
            $_SESSION['product'][$id]['count'] += $value['count'];
        } else {
            $_SESSION['product'][$id] = $value;
        }
    }
}
// カート内に商品があるか確認
if (isset($_SESSION['product'])) {
    // 個数が0個の商品をunsetします
    foreach ($_SESSION['product'] as $key => $value) {
        if ($value['count'] <= 0) {
            unset($_SESSION['product'][$key]);
        }
    }
    if (empty($_SESSION['product'])) {
        $checker = false;
        unset($_SESSION['product']);
    }
    $total = 0;
    // 全部フォームで出力します
    echo '<form name="purchase"  method="post" action="purchase-complete.php">';
    echo '<h3>ご購入商品</h3>';
    //  カートに商品が入っているか確認
    if (isset($_SESSION['product'])) {
        foreach ($_SESSION['product'] as $id => $product) {
            $subtotal = $product['price'] * $product['count'];
            $total += $subtotal;
            $formatSubTotal = number_format($subtotal);
            echo <<<CART
<div class="border-topbottom">
<div class="row">
<p class="left">商品名</p>
<p class="right">{$product['name']}</p>
</div>
<div class="row">
<p class="left">数量</p>
<p class="right">{$product['count']}個</p>
</div>
<div class="row">
<p class="left">小計</p>
<p class="right">税込&yen;{$formatSubTotal}</p>
</div>
</div>
CART;
        }
        $formatTotal = number_format($total);
        echo <<<TOTAL
<div class="border-topbottom">
<div class="row">
<p class="left">合計</p>
<p class="right bold">税込&nbsp;&yen;{$formatTotal}円</p>
</div>
</div>        
TOTAL;
    } else {
        echo '<p class="border-topbottom-red alert">カートに商品がありません</p>';
    }
}
// お届け先
echo '<h3>お届け先</h3>';

if (isset($_SESSION['customer'])) {
    $sql = $pdo->prepare('select * from customer where id=?');
    $sql->execute([$_SESSION['customer']['id']]);
    $customerData = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo <<<DERIVER
<div class="border-topbottom">
<div class="row">
<p class="left">お名前</p>
<p class="right">{$customerData['0']['name']}</p>
</div>
<div class="row">
<p class="left">住所</p>
<p class="right">{$customerData['0']['address']}</p>
</div>
</div>
DERIVER;
} else {
    echo '<p class="border-topbottom-red alert">ログインしていません</p>';
    echo '<a href="login-input.php" class="button">ログインする</a>';
}

// クレジットカード情報が登録されているか確認
if (isset($_SESSION['customer'])) {
    $sql = $pdo->prepare('select * from card where id=?');
    $sql->execute([$_SESSION['customer']['id']]);
    $card = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo '<h3>お支払方法</h3>';
    if (isset($_SESSION['customer']) && isset($_SESSION['product'])) {
        if (!empty($card)) {
            $number = substr($card['0']['card_no'], 0, 6);
            echo <<<PAYMENT
<div class="border-topbottom purchase-card">
<div class="row">
<p class="left">お支払方法</p>
<p class="right">クレジットカード</p>
</div>
<div class="row">
<p class="left">カード種類</p>
<p class="right">{$card['0']['card_type']}</p>
</div>
<div class="row">
<p class="left">カード番号</p>
<p class="right">{$number}●●●●●●●●●●</p>
</div>
</div>
<input type="submit" class="button" value="ご購入を確定する"></input>
</form>
PAYMENT;
        } else {
            echo '<p class="red border-topbottom-red alert">お支払方法が登録されていません<br>クレジットカード情報を登録してください</p>';
            echo '<a href="card-input.php" class="button">カード情報を登録する</a></form>';
        }
    }
}
echo '</section>';
?>
</body>

<?php require './includes/footer.php'; ?>