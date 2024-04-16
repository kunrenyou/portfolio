<?php require './includes/header.php'; ?>

<section class="top">
    <div class="hero-img"></div>
    <div class="content-wrap">
        <a href="detail-1.php?id=5" class="content-top-square figure-1 anim anim-ver1">
            <p class="badge">新商品</p>
            <p class="top-description">サマーシトラス</p>
        </a>
        <div class="content-top-square figure-2 anim anim-ver2">
            <p class="top-description">ドーナツのある生活</p>
        </div>
        <a href="product.php" class="content-top-lect anim">
            <p class="top-description">商品一覧</p>
        </a>
    </div>
</section>
<section class="philosophy">
    <h2 class=" anim">philosophy</h2>
    <p class=" anim">私たちの信念</p>
    <p class=" anim"><span>"creating connection"</span></p>
    <p class=" anim">ドーナツでつながる。</p>
</section>
<section class="ranking">
    <h2 class="section-title">人気ランキング</h2>
    <ol class="index-ranking">
        <?php
        // データベースからお気に入り数順にソートしたリストを取得、第二ソートは売上数
        $query = <<<SQL
select pr.id,pr.name,pr.price,pr.category,fav.favs,ifnull(pu.count,0) as count from product as pr
left join(select product_id,count(product_id) as favs from favorite group by product_id) as fav on pr.id=fav.product_id
left join(select product_id,ifnull(sum(count),0) as count from purchase_detail group by product_id) as pu on pr.id=pu.product_id
order by favs desc,count desc        
SQL;
        $sql = $pdo->query($query);
        $ranking = $sql->fetchall();
        for ($i = 0; $i < 6; $i++) {
            $favicon = '<div class="heart likes-icon" data-id="' . $ranking[$i]['id'] . '"><i class="fa-regular fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$ranking[$i]['id']] . '</p></div>';
            if (isset($_SESSION['favorite'][$ranking[$i]['id']])) {
                $favicon = '<div class="heart likes-icon on" data-id="' . $ranking[$i]['id'] . '"><i class="fa-solid fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$ranking[$i]['id']] . '</p></div>';
            }
            $rank = $i + 1;
            $price = number_format($ranking[$i]['price']);
            echo <<<LIST
<li>
<p class="rank-number">{$rank}</p>
<a href="detail-1.php?id={$ranking[$i]['id']}">
<div class="size-lock">
<img src="common/images/product-{$ranking[$i]['id']}.png" alt="人気ランキング{$ranking[$i]['id']}番の商品画像" />
</div>
<p class="ranking-name">{$ranking[$i]['name']}</p>
</a>
<div class="row-wrap">
<p class="ranking-price">税込<span>&yen;{$price}</span></p>
{$favicon}
</div>
<form action="cart-input.php" method="post" name="{$ranking[$i]['id']}">
<input type="hidden" name="id" value="{$ranking[$i]['id']}">
<input type="hidden" name="name" value="{$ranking[$i]['name']}">
<input type="hidden" name="price" value="{$ranking[$i]['price']}">
<input type="hidden" name="count" value="1">
<input type="submit" class="button" value="カートに入れる">
</form>
</li>
LIST;
        }
        ?>
    </ol>
</section>
<?php require './includes/footer.php'; ?>