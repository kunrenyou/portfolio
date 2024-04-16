<?php
require 'includes/header.php';
require 'favorite.php';
// 単品商品の一覧表示
echo '<section class="category1">';
?>
<form class="row sort-form" method="get" action="product.php">
    <p>並べ替え：</p>
    <select name="sort" class="sort">
        <!-- selectのオプションを自動選択するためのコードです -->
        <?php
        for ($i = 1; $i <= 5; $i++) {
            $optionTitle = [
                '1' => '商品番号', '2' => '価格', '3' => '名前', '4' => '人気', '5' => '売上'
            ];
            $isSelected = '';
            if (isset($_GET['sort'])) {
                if (($_GET['sort'] == $i)) {
                    $isSelected = ' selected ';
                }
            }
            echo <<<OPTION
<option value="{$i}"{$isSelected}>{$optionTitle[$i]}</option>
OPTION;
        }
        ?>
    </select>
    <p>絞り込み：</p>
    <select name="category" class="category">
        <?php
        for ($i = 0; $i <= 2; $i++) {
            $optionTitle = ['0' => 'すべて表示', '1' => '個別商品', '2' => 'バラエティーセット'];
            $isSelected = '';
            if (isset($_GET['category'])) {
                if (($_GET['category'] == $i)) {
                    $isSelected = ' selected ';
                }
            }
            echo <<<OPTION
<option value="{$i}" {$isSelected}>{$optionTitle[$i]}</option>
OPTION;
        }
        ?>
    </select>
    <?php
    if (isset($_GET['search'])) {
        echo '<input type="hidden" name="search" value="' . $_GET['search'] . '">';
    }
    ?>
</form>
<!-- selectが変更された時にクエリメッセージを変更して自動的にソートや絞り込みをします -->
<script>
    $(document).ready(function() {
        const params = new URLSearchParams(window.location.search);
        const $sort = $('.sort');
        const $category = $('.category');
        $sort.on('change', function() {
            params.set("sort", $sort.val());
            const newparams = location.pathname + '?' + params;
            location.href = newparams;

        });
        $category.on('change', function() {
            params.set("category", $category.val())
            const newparams = location.pathname + '?' + params;
            location.href = newparams;
        });
    });
</script>
<?php
if (!$_GET) {
    echo '<h2 class="section-title">商品一覧</h2>';
    echo '<ul class="product-list">';
    $list = $pdo->query('select * from product where category=1');
    $datas = $list->fetchAll();
    foreach ($datas as $row) {
        $favicon = '<div class="heart likes-icon" data-id="' . $row['id'] . '"><i class="fa-regular fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        if (isset($_SESSION['favorite'][$row['id']])) {
            $favicon = '<div class="heart likes-icon on" data-id="' . $row['id'] . '"><i class="fa-solid fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        }
        $price = number_format($row['price']);
        echo '<li>';
        echo '<a href="detail-1.php?id=' . $row['id'] . '">', '<div class="size-lock"><img alt="image" src="common/images/product-', $row['id'], '.png"></div>';
        echo '<p class="product-name">', htmlspecialchars($row['name']), '</p></a>';
        echo '<div class="row-wrap"><p class="product-price">', '税込', '&nbsp;', '￥', htmlspecialchars($price), '</p>';
        echo $favicon;
        echo '</div><form action="cart-input.php" method="post" name="' . $row['id'] . '">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="name" value="' . $row['name'] . '">';
        echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
        echo '<input type="hidden" name="count" value="1">';
        echo '<input type="submit" class="button" value="カートに入れる"></input>';
        echo '</form>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</section>';

    // バラエティセットの一覧表示
    echo '<section class="category2">';
    echo '<h2 class="section-title">バラエティセット</h2>';
    echo '<ul class="product-list">';
    foreach ($pdo->query('select * from product where category=2') as $row) {
        $favicon = '<div class="heart likes-icon" data-id="' . $row['id'] . '"><i class="fa-regular fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        if (isset($_SESSION['favorite'][$row['id']])) {
            $favicon = '<div class="heart likes-icon on" data-id="' . $row['id'] . '"><i class="fa-solid fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        }
        $price = number_format($row['price']);
        echo '<li>';
        echo '<a href="detail-1.php?id=', $row['id'], '">', '<div class="size-lock"><img alt="image" src="common/images/product-', $row['id'], '.png"></div>';
        echo '<p class="product-name">', htmlspecialchars($row['name']), '</p></a>';
        echo '<div class="row-wrap"><p class="product-price">', '税込', '&nbsp;', '￥', htmlspecialchars($price), '</p>';
        echo $favicon;
        echo '</div><form action="cart-input.php" method="post" name="' . $row['id'] . '">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="name" value="' . $row['name'] . '">';
        echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
        echo '<input type="hidden" name="count" value="1">';
        echo '<input type="submit" class="button" value="カートに入れる"></input>';
        echo '</form>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</section>';
} else {
    $searchQuery = '';
    $category = '\'%\'';
    $order = 'id';
    $sortmap = [
        'category' => [
            '0' => '\'%\'',
            '1' => '1',
            '2' => '2'
        ],
        'order' => [
            '1' => 'id',
            '2' => 'price',
            '3' => 'name',
            '4' => 'favs desc',
            '5' => 'count desc'
        ]
    ];
    if (isset($_GET['search'])) {
        $searchQuery = mb_convert_kana($_GET['search'], 'S');
    }
    if (isset($_GET['sort'])) {
        $order = $sortmap['order'][$_GET['sort']];
    }
    if (isset($_GET['category'])) {
        $category = $sortmap['category'][$_GET['category']];
    }
    $sqlorder = <<<SQL
select pr.id,pr.name,pr.price,pr.category,ifnull(fav.favs,0),ifnull(pu.count,0) as count from product as pr
left join(select product_id,count(product_id) as favs from favorite group by product_id) as fav on pr.id=fav.product_id
left join(select product_id,ifnull(sum(count),0) as count from purchase_detail group by product_id) as pu on pr.id=pu.product_id
where category like {$category} and name like '%{$searchQuery}%' order by {$order}
SQL;
    $sql = $pdo->prepare($sqlorder);
    $sql->execute();
    $list = $sql->fetchAll();
    echo '<h2 class="section-title">商品一覧</h2>';
    echo '<ul class="product-list">';
    foreach ($list as $row) {
        $favicon = '<div class="heart likes-icon" data-id="' . $row['id'] . '"><i class="fa-regular fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        if (isset($_SESSION['favorite'][$row['id']])) {
            $favicon = '<div class="heart likes-icon on" data-id="' . $row['id'] . '"><i class="fa-solid fa-heart"></i><p class="favnum">' . $_SESSION['favnum'][$row['id']] . '</p></div>';
        }
        $price = number_format($row['price']);
        echo '<li>';
        echo '<a href="detail-1.php?id=' . $row['id'] . '">', '<div class="size-lock"><img alt="image" src="common/images/product-', $row['id'], '.png"></div>';
        echo '<p class="product-name">', htmlspecialchars($row['name']), '</p></a>';
        echo '<div class="row-wrap"><p class="product-price">', '税込', '&nbsp;', '￥', htmlspecialchars($price), '</p>';
        echo $favicon;
        echo '</div>';
        echo '<form action="cart-input.php" method="post" name="' . $row['id'] . '">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="name" value="' . $row['name'] . '">';
        echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
        echo '<input type="hidden" name="count" value="1">';
        echo '<input type="submit" class="button" value="カートに入れる"></input>';
        echo '</form>';
        echo '</li>';
    }
    echo '</ul>';
}
require 'includes/footer.php';
