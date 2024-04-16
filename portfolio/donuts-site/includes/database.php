<?php
const LOCALHOST = 'mysql:host=localhost;dbname=donuts;charset=utf8';
const DB_CONTAINER = 'mysql:host=db;dbname=donuts;charset=utf8';
// ↓↓↓サーバーアップロード時書き換えるのはここ↓↓↓
const SERVER = 'mysql:host=mysql1.php.starfree.ne.jp;dbname=okxxxxxxx3_donuts;charset=utf8';
$errorLocalhost = $errorContainer = $errorServer = '';


try {
    $pdo = new PDO(LOCALHOST, 'donuts', 'password');
} catch (PDOException $e) {
    $errorLocalhost = 'localhost:' . $e;
}
if ($errorLocalhost) {
    try {
        $pdo = new PDO(DB_CONTAINER, 'donuts', 'password');
    } catch (PDOException $e) {
        $errorContainer = 'container' . $e;
    }
}
if ($errorContainer && $errorLocalhost) {
    try {
        // ↓↓↓サーバーアップロード時書き換えるのはここ↓↓↓
        $pdo = new PDO(SERVER, 'okxxxxxxx3_cca', 'ccadonuts');
    } catch (PDOException $e) {
        $errorServer = 'SERVER' . $e;
    }
}
if ($errorContainer && $errorLocalhost && $errorServer) {
    echo '<p>', $errorLocalhost, '</p><p>', $errorContainer, '</p><p>', $errorServer, '</p>';
}
