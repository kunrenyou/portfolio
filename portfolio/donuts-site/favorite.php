<?php

if (!isset($_SESSION['favorite'])) {
    $_SESSION['favorite'] = array();
}
if (isset($_SESSION['customer'])) {
    $id = $_SESSION['customer']['id'];
    $query = <<<SQL
select * from favorite where customer_id={$id}
SQL;
    $sql = $pdo->prepare($query);
    $sql->execute();
    $favdata = $sql->fetchall(PDO::FETCH_ASSOC);
    $favlist = array();
    // ユーザのfavリストをセッション内に保存します
    foreach ($favdata as $data) {
        $favlist[$data['product_id']] = true;
        if (!isset($_SESSION['favorite'][$data['product_id']])) {
            $_SESSION['favorite'][$data['product_id']] = true;
        }
    }
    if (isset($_SESSION['favorite'])) {
        // ログイン前にセッションfavを利用していた場合データベースのものにセッション情報を書き換える処理
        foreach ($_SESSION['favorite'] as $no => $data) {
            if (!isset($favlist[$no])) {
                unset($_SESSION['favorite'][$no]);
            }
        }
    }
}
// データベースに保存されている総favを商品idごとに取得します
$_SESSION['favnum'] = array();
$favnumQuery = <<<SQL
select pr.id as product_id,ifnull(fav.favs,0) as favnum from product as pr
left join (
    select product_id,ifnull(count(product_id),0) as favs from favorite group by product_id
)as fav on pr.id=fav.product_id
SQL;
$sql = $pdo->prepare($favnumQuery);
$sql->execute();
$favnums = $sql->fetchAll(PDO::FETCH_ASSOC);
foreach ($favnums as $favdata) {
    $_SESSION['favnum'][$favdata['product_id']] = $favdata['favnum'];
}
