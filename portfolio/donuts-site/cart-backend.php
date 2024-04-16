<?php
session_start();

if ($_POST) {
    $_SESSION['product'][$_POST['id']]['count'] = $_POST['count'];
}
// 新しく送られてきた個数
$count = $_POST['count'];
// 数値の初期化
$totalPrice = 0;

foreach ($_SESSION['product'] as $key => $value) {
    // カートに入っているidごとに単価*個数を加算し続ける
    $totalPrice += $value['price'] * $value['count'];
}
// javascriptに戻すデータです
$data = [
    'count' => $count,
    'totalPrice' => $totalPrice
];
// JSON形式に変換
echo json_encode($data);
