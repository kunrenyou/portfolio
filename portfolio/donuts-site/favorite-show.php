<?php
require 'includes/header.php';
?>
<section class="favorite category1">
    <h2 class="section-title">お気に入り一覧</h2>
    <?php
    if ($_SESSION['favorite']) {
        echo <<<HTML
<ul class="product-list"></ul>
<form action="purchase-confirm.php" method="post" class="goPurchase">
<input type="submit" class="button packbutton" value="まとめて購入する">
</form>
HTML;
    } else {
        echo '<p class="text-center">お気に入り商品が設定されていません</p>';
    }
    ?>
    <?php
    $sql = $pdo->query('select pr.id as id,pr.name,pr.price,ifnull(fav.favs,0) as favs from product as pr left join (select product_id,ifnull(count(product_id),0) as favs from favorite group by product_id) as fav on pr.id=fav.product_id;');
    $productList = $sql->fetchAll(pdo::FETCH_ASSOC);
    ?>
    <script>
        $(document).ready(function() {

            const productList = <?php echo json_encode($productList); ?>;
            const favs = <?php echo json_encode($_SESSION['favorite']); ?>;
            const favArray = Object.keys(favs);
            const showListData = []
            favArray.forEach(id => {
                showListData.push(productList[id - 1])
            });
            console.log(showListData);
            // リスト表示処理作成途中
            showListData.forEach(data => {
                const showLists = '<li><a href="detail-1.php?id="' + data.id + '"><div class="size-lock"><img alt="image" src="common/images/product-' + data.id + '.png"></div><p class="product-name">' + data.name + '</p></a><div class="row-wrap"><p class="product-price">税込 ￥' + data.price + '</p><div class="heart likes-icon on" data-id="' + data.id + '"><i class="fa-solid fa-heart"></i><p class="favnum">' + data.favs + '</p></div></div><form action="cart-input.php" method="post" name="' + data.id + '"><input type="hidden" name="id" value="' + data.id + '"><input type="hidden" name="name" value="' + data.name + '"><input type="hidden" name="price" value="' + data.price + '"><input type="hidden" name="count" value="1"><input type="submit" class="button" value="カートに入れる"></input></form></li>';
                $('.product-list').append(showLists);
                const packInput = '<input type="hidden" name="' + data.id + '[name]" value="' + data.name + '"><input type="hidden" name="' + data.id + '[price]" value="' + data.price + '"><input type="hidden" name="' + data.id + '[count]" value="1">';
                $('.goPurchase').append(packInput);
            });

        });
    </script>

</section>
<?php
require 'includes/footer.php'; ?>