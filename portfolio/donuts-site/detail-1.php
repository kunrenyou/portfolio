<?php require './includes/header.php'; ?>
<?php
if (isset($_REQUEST['id'])) {
    // 商品番号が一致するレコードを取得
    $sql = $pdo->prepare('select * from product where id=?');
    // product.phpで指定したa属性のid値
    $sql->execute([$_REQUEST['id']]);
    // HTMLで出力
    echo '<section class="detail"><form action="cart-input.php" method="post"><div class="detail-wrap">';
    foreach ($sql as $row) {
        $favicon = '<div class="heart likes-icon" data-id="' . $row['id'] . '"><i class="fa-regular fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        if (isset($_SESSION['favorite'][$row['id']])) {
            $favicon = '<div class="heart likes-icon on" data-id="' . $row['id'] . '"><i class="fa-solid fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        }
        $price = number_format($row['price']);
        echo <<<END
<div class="detail-left">
<image class="detail-img" alt="image" src="common/images/product-{$row['id']}.png">
</div>
<div class="detail-right">
<p class="product-name bold">{$row['name']}</p>
<p class="product-text border-topbottom">{$row['description']}</p>
<div class="row">
<p class="product-price"><span>税込　￥{$price}</span></p>
{$favicon}
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
    echo '</section>';
}
?>

<?php require './includes/footer.php'; ?>