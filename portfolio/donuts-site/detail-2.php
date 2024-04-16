<?php require './includes/header.php'; ?>

</body>
<?php
// 商品番号が一致するレコードを取得
$sql = $pdo->prepare('select * from product where id=?');
// product.phpで指定したa属性のid値
$sql->execute([$_REQUEST['id']]);
// HTMLで出力
echo '<section class="detail"><form action="cart-input.php" method="post"><div class="detail-wrap">';
foreach ($sql as $row) {
    echo <<<END
<div class="detail-left">
<image class="detail-img" alt="image" src="common/images/product-{$row['id']}.png">
</div>
<div class="detail-right">
<p class="product-name bold">{$row['name']}</p>
<p class="product-text border-topbottom">{$row['description']}</p>
<div class="row">
<p class="product-price"><span>税込　￥{$row['price']}</span></p>
<div class="heart likes-icon">
<i class="fa-regular fa-heart"></i>
</div>
</div>
<div  class="row">
<input type="text" name="count" value="1"><p class="subscript">個</p>
<input type="submit" class="button" value="カートに入れる"></input>
<input type="hidden" name="id" value="{$row['id']}">
<input type="hidden" name="name" value="{$row['name']}">
<input type="hidden" name="price" value="{$row['price']}">
</div>
</div>
</form>
END;
}
// <a href="cart-input.php?id={$row['id']}" class="button">カートに入れる</a>
// <div class="button">カートに入れる</div></a>
echo '</section>';



?>
<!-- ハートのアニメスクリプト -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $('.likes-icon').on('click', function() {
        const $btn = $(this);
        console.log($btn);
        if ($btn.hasClass('on')) {
            $btn.removeClass('on');
            $btn.children("i").attr('class', 'fa-regular fa-heart');
        } else {
            $btn.addClass('on');
            $btn.children("i").attr('class', 'fa-solid fa-heart anim-heart');

        }
    })
</script>
<?php require './includes/footer.php'; ?>