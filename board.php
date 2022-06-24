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
$id = $_GET['id'];
$sql = 'SELECT * FROM `boards` WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$stmt->execute();
$board = $stmt->fetch();

if (empty($board)) {
    header('Location: /vantan_board/index.php');
    exit;
}

$sql = 'SELECT * FROM `comments` WHERE boardId = :boardId ORDER BY createdAt';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':boardId', $id, PDO::PARAM_STR);
$stmt->execute();
$comments = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $board['title'] ?></title>
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
    <h1><?php echo $board['title'] ?></h1>
</header>
<div>
    <ul>
        <?php
        foreach ($comments as $comment) {
            echo "<li>{$comment['comment']}</li>";
        }
        ?>
    </ul>
</div>
</body>
</html>
