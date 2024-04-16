<?php
session_start();
// database.phpが既に読み込まれている場合は2重で読み込まないようにする
if (!defined('LOCALHOST') && !defined('DB_CONTAINER') && !defined('SERVER')) {
    require 'includes/database.php';
}
require 'favorite.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donuts-Site</title>
    <!-- destyle.css -->
    <link rel="stylesheet" href="common/css/reset.css">
    <!-- style.css -->
    <link rel="stylesheet" href="common/css/common.css">
    <!-- googlefonts(Noto Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <script src="https://kit.fontawesome.com/185375e97d.js" crossorigin="anonymous"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!--favicon  -->
    <link rel="icon" href="/common/images/favicon.svg" sizes="any" type="image/svg+xml">
</head>
<?php
// ログイン名の表示の処理
if (isset($_SESSION['customer'])) {
    $message = 'ログアウト';
    $gre = 'ようこそ、' . $_SESSION['customer']['name'] . '様';
    $link = 'logout-input.php';
} else {
    $message = 'ログイン';
    $gre = 'ようこそ、ゲスト様';
    $link = 'login-input.php';
}
// パンくずリストの表示の処理
$return = '';
const TOP = '<div class="breadcrumb"><ul class="row"><li><a href="index.php">TOP</a></li>';
const PRODUCT = '<li>&gt;<a href="product.php">商品一覧</a></li>';
const CART = '<li>&gt;<a href="cart-show.php">カート</a></li> ';
const HEADER = '<header class="header2"><h1 class="h1_2"><a href="./index.php"><img src="./common/images/shop-logo.svg" alt="DONUTS-SITE"></a></h1></header>';
$currentUrl = $_SERVER['REQUEST_URI'];

if (preg_match('/product/', $currentUrl)) {
    $return .= TOP . PRODUCT . '</ul></div>';
}
if (preg_match('/detail/', $currentUrl)) {
    if (isset($_GET['id'])) {
        $sql = $pdo->prepare('select name from product where id=?');
        $sql->execute([$_GET['id']]);
        $data = $sql->fetch();
        $name = $data['name'];
        $return .= TOP . PRODUCT . '<li>&gt;' . $name . '</li></ul></div>';
    }
}
if (preg_match('/cart/', $currentUrl)) {
    $return .= TOP . CART . '</ul></div>';
}

if (preg_match('/customer/', $currentUrl) || preg_match('/card/', $currentUrl) || preg_match('/purchase/', $currentUrl)) {
    echo HEADER;
} else {

    echo <<<END
<body>
<div id="wrapper">
<div class="row">
<a href="./index.php"><img src="./common/images/shop-logo.svg" alt="DONUTS-SITE"></a>
<div class="navbtn btn-in-wrap"></div>
</div>
<nav id="nav">
<ul>
<li><a href="index.php">TOP</a></li>
<li><a href="product.php">商品一覧</a></li>
<li><a href="#">よくある質問</a></li>
<li><a href="#">問い合わせ</a></li>
<li><a href="#">当サイトのポリシー</a></li>
</ul>
</nav>
</div>
</div>
<header class="header">
        <div class="header-inner">
            <div class="navbtn"></div>
            <h1><a href="./index.php"><img src="./common/images/shop-logo.svg" alt="DONUTS-SITE"></a></h1>
            <div class="icon-fav"><a href="favorite-show.php">
                <i class="fa-regular fa-heart header-fa"></i>
            <p>お気に入り</p></a></div>
            <div class="icon-login"><a href="{$link}">                
                <img src="./common/images/icon-login.svg" alt="ログイン・ログアウト">
            <p>{$message}</p></a></div>
            <div class="icon-cart">
            <a href="./cart-show.php"><img src=./common/images/icon-cart.svg alt="カート"><p>カート</p></div></a>
        </div>
        <!-- 検索 --> 
        <div class="search">          
        <form class="search-box" action="product.php" method="get">
            <input class="search-text" type="search" name="search" placeholder="">
            <input class="search-submit" type="submit" value="" aria-label="search-submit-button">
        </form>
        </div>       
</header>
{$return}
<div class="welcome"><p>{$gre}</p></div>

END;
}
?>