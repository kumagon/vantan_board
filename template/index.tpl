<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>トップ</title>
</head>
<body>
{include file="./common/header.tpl"}
<h1>トップ</h1>
<div>{$user->name}さんようこそ</div>
<div>
    <h2>掲示板一覧</h2>
    <ul>
        {foreach from=$boardList item=board}
            <li><a href='/vantan_board/board.php?id={$board->id}'>{$board->title}</a></li>
        {/foreach}
    </ul>
</div>
</body>
</html>
