<?php
session_start();

if (empty($_SESSION['id'])) {
    header('Location: /vantan_board/index.php');
    exit;
}

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
if (!empty($_POST['title'])) {
    $title = $_POST['title'];

    $sql = 'INSERT INTO `boards` (title, userId, createdAt)';
    $sql .= ' VALUES (:title, :userId, NOW())';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':userId', $_SESSION['id'], PDO::PARAM_INT);
    $result = $stmt->execute();
    if($result) {
        $message = '掲示板を作成しました';
        header('Location: /vantan_board/board.php?id=' . $pdo->lastInsertId());
        exit;
    } else {
        $message = '登録に失敗しました';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>掲示板新規作成</title>
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
    <h1>掲示板新規作成</h1>
</header>
<div>
    <div style="color: red">
        <?php echo $message; ?>
    </div>
    <form action="/vantan_board/create_board.php" method="post">
        <label>タイトル: <input type="text" name="title"/></label><br/>
        <input type="submit" value="新規作成">
    </form>
</div>
</body>
</html>
