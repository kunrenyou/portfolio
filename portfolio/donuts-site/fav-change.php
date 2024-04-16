<?php
// 裏の処理なのでセッションスタートが必要
session_start();
require 'includes/database.php';
// fav関連セッションの情報を切り替えて、scriptに戻します
if (isset($_SESSION['favorite'][$_POST['product_id']])) {
    unset($_SESSION['favorite'][$_POST['product_id']]);
    $_SESSION['favnum'][$_POST['product_id']]--;
    echo $_SESSION['favnum'][$_POST['product_id']];
} else {
    $_SESSION['favorite'][$_POST['product_id']] = true;
    $_SESSION['favnum'][$_POST['product_id']]++;
    echo $_SESSION['favnum'][$_POST['product_id']];
}
// ログイン中はデータベースも書き換えます
if (isset($_SESSION['customer'])) {
    $query = <<<SQL
select * from favorite where customer_id={$_SESSION['customer']['id']} and product_id={$_POST['product_id']}    
SQL;
    $sql = $pdo->prepare($query);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    if (empty($data)) {
        $sql = $pdo->prepare('insert into favorite values(?,?)');
        $sql->execute([$_SESSION['customer']['id'], $_POST['product_id']]);
    } else {
        $sql = $pdo->prepare('delete from favorite where customer_id=? and product_id=?');
        $sql->execute([$_SESSION['customer']['id'], $_POST['product_id']]);
    }
}
