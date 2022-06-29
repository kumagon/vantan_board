<?php
session_start();

$message = '';
try {
    $DBSERVER = 'localhost';
    $DBUSER = 'board';
    $DBPASSWD = 'boardpw';
    $DBNAME = 'board';

    $dsn = 'mysql:'
        . 'host=' . $DBSERVER . ';'
        . 'dbname=' . $DBNAME . ';'
        . 'charset=utf8';
    $pdo = new PDO($dsn, $DBUSER, $DBPASSWD, array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (Exception $e) {
    $message = "接続に失敗しました: {$e->getMessage()}";
}

$sql = 'SELECT * FROM `boards` ORDER BY id DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$boards = $stmt->fetchAll();

$boardIds = [];
foreach ($boards as $board) {
    $boardIds[$board['id']] = $board['id'];
}
$boardIdsString = implode(',', $boardIds);
$sql = "SELECT * FROM `users` WHERE id IN '$boardIdsString'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
$userData = [];
foreach ($users as $user) {
    $userData[$user['id']] = $user;
}
var_dump($boards);
var_dump($userData);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>トップ</title>
</head>
<body>
<header>
    <div>
        <a href="/vantan_board/index.php">TOP</a>
        <a href="/vantan_board/register.php">新規作成</a>
        <a href="/vantan_board/login.php">ログイン</a>
        <a href="/vantan_board/logout.php">ログアウト</a>
        <a href="/vantan_board/create_board.php">掲示板作成</a>
    </div>
    <h1>トップ</h1>
</header>
<div>
    <?php echo  htmlspecialchars("{$_SESSION['name']}さんようこそ"); ?>
</div>
<div>
    <h2>掲示板一覧</h2>
    <ul>
    <?php
    foreach ($boards as $board) {
        echo "<li><a href=\"/vantan_board/board.php?id={$board['id']}\" >{$board['title']}（{$userData[$board['userId']]['name']}）</a></li>";
    }
    ?>
    </ul>
</div>
</body>
</html>
