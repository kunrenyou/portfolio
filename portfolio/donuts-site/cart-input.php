<?php
require 'includes/header.php';
?>
<section class="cart">
    <?php
    // session_unset();

    $mbcount = mb_convert_kana($_REQUEST['count'], 'n');
    $intcount = intval($mbcount);
    if (isset($_REQUEST['id']) && $intcount != 0) {
        echo '<p>カートに商品を追加しました。</p>';
        $id = $_REQUEST['id'];
        if (!isset($_SESSION['product'])) {
            $_SESSION['product'] = [];
        }
        $count = 0;
        if (isset($_SESSION['product'][$id])) {
            $count = $_SESSION['product'][$id]['count'];
        }
        // フォームから送信された個数を数字に変換
        if (isset($_REQUEST['count'])) {
            (int)$plusCount = intval($_REQUEST['count']);
        }
        $_SESSION['product'][$id] = [
            'name' => $_REQUEST['name'],
            'price' => $_REQUEST['price'],
            'count' => $count + $intcount
        ];
    }
    require 'cart.php';
    ?>
</section>
<?php require './includes/footer.php'; ?>