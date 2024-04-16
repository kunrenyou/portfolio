<?php
// unset($_SESSION['product']);
if (isset($_SESSION['product'])) {
    foreach ($_SESSION['product'] as $key => $value) {
        if ($value['count'] <= 0) {
            unset($_SESSION['product'][$key]);
        }
    }
    $totalPrice = 0;
    echo '<ul class="cart-list">';
    if (!empty($_SESSION['product'])) {
        $sorted = array_reverse($_SESSION['product'], true);
        foreach ($sorted as $id => $data) {
            $totalPrice += $data['price'] * $data['count'];
            $formatPrice = number_format($data['price']);
            echo <<<LIST
<li id="element">
<div class="left">
<img src="common/images/product-{$id}.png" alt="商品画像" >
</div>
<div class="right">
<p class="cart-title bold">{$data['name']}</p>
<div class="border-topbottom row sp-none">
<p><span>税込 ￥{$formatPrice}</span></p>

<form action="cart-change.php" method="post" class="cartform">
<div class="row">

<input type="button" name="plus" value="+">
<input type="text" class="disabled" name="count" value="{$data['count']}" disabled>
<input type="button" name="minus" value="－">
<p class="pt-1">個</p>
</div>
<input type="hidden" name="id" value="{$id}">
<input type="hidden" name="name" value="{$data['name']}">
<input type="hidden" name="price" value="{$data['price']}">
</form>

<p><a href="cart-delete.php?id={$id}"><small>削除する</small></a></p>
</div>
</div>
</li>    
LIST;
        }
        echo '</ul>';
        $formatTotalPrice = number_format($totalPrice);
        echo <<<TOTAL
<div class="border-square">
<p>ご注文合計:<span id="totalPrice"></span></p>
<p>ご注文合計:<span id="totalPrice"></span></p>
<a href="purchase-confirm.php" class="button">ご購入確認に進む</a>
</div>
<a href="product.php" class="button w-50">お買い物を続ける</a>
TOTAL;
    } else {
        echo '<p>カートに商品がありません</p>';
    }
} else {
    echo '<p>カートに商品がありません</p>';
}
?>
<!-- カート内の商品個数を増減させるjs -->
<script>
    'use strict';
    window.onload = () => {
        // 値段の取得
        const totalPrice = document.getElementById('totalPrice');
        // console.log(totalPrice);　これは文字列

        // 数値として取得、出力
        let numTotalPrice = <?php echo $totalPrice; ?>;
        if (totalPrice) {
            // toLocaleStringはコンマを入れる関数
            totalPrice.textContent = '税込￥' + numTotalPrice.toLocaleString() + '円';
        }
        // +ボタンを押したとき
        const cartform = document.querySelectorAll('.cartform');
        cartform.forEach(forms => {
            forms.plus.addEventListener('click', () => {
                const int = parseInt(forms.count.value);
                const pluscount = int + 1;
                // Jqueryで記述 JSON形式に変換
                $.post({
                    url: 'cart-backend.php',
                    data: {
                        id: forms.id.value,
                        name: forms.name.value,
                        price: forms.price.value,
                        count: pluscount,
                    },
                    datatype: JSON,
                }).done(
                    function(res) { // 値段を計算、出力 連打した際の遅れの対処
                        const response = JSON.parse(res);
                        forms.count.value = parseInt(response.count);
                        // const thisPrice=forms.price.value;
                        // numTotalPrice=Number(numTotalPrice)+Number(thisPrice);
                        totalPrice.textContent = '税込￥' + parseInt(response.totalPrice).toLocaleString() + '円';
                    }
                )
                // forms.count.value = pluscount;
                // console.log(Number(numTotalPrice)+Number(thisPrice));
            });
            // -ボタンを押したとき
            forms.minus.addEventListener('click', () => {
                const int = parseInt(forms.count.value);
                const minuscount = int - 1;
                if (minuscount >= 0) {
                    $.post({
                        url: 'cart-backend.php',
                        data: {
                            id: forms.id.value,
                            name: forms.name.value,
                            price: forms.price.value,
                            count: minuscount,
                        },
                        datatype: JSON,
                    }).done(
                        function(res) {
                            // 値段を計算、出力 連打した際の遅れの対処
                            const response = JSON.parse(res);
                            forms.count.value = parseInt(response.count);
                            // const thisPrice=forms.price.value;
                            // numTotalPrice=Number(numTotalPrice)+Number(thisPrice);
                            totalPrice.textContent = '税込￥' + parseInt(response.totalPrice).toLocaleString() + '円';
                        }
                    )
                    // forms.count.value = minuscount;
                    // 商品の値段を取得、計算して出力
                    // const thisPrice=forms.price.value;
                    // numTotalPrice=Number(numTotalPrice)-Number(thisPrice);
                    // totalPrice.textContent='税込￥'+numTotalPrice.toLocaleString()+'円';
                }
            });
        });
    }
</script>