<?php require 'includes/header.php'; ?>
<section class="cart">
    <?php
    unset($_SESSION['product'][$_REQUEST['id']]);
    echo <<<END
<p>カートから商品を削除しました。</p>
END;
    require 'cart.php';
    ?>
</section>
<?php require 'includes/footer.php'; ?>