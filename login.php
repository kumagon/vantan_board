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
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM `users` WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch();
    if(!empty($user['id']) && $user['password'] === $password) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
        $_SESSION['name'] = $user['name'];
        header('Location: /vantan_board/index.php');
        exit;
    } else {
        $message = 'ログインに失敗しました';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
<header>
    <div>
        <a href="/vantan_board/index.php">TOP</a>
        <a href="/vantan_board/register.php">新規作成</a>
        <a href="/vantan_board/login.php">ログイン</a>
        <a href="/vantan_board/logout.php">ログアウト</a>
    </div>
    <h1>ログイン</h1>
</header>
<div>
    <div style="color: red">
        <?php echo $message; ?>
    </div>
    <form action="/vantan_board/login.php" method="post">
        <label>メールアドレス: <input type="email" name="email"/></label><br/>
        <label>パスワード: <input type="password" name="password"/></label><br/>
        <input type="submit" value="ログイン">
    </form>
</div>
</body>
</html>
