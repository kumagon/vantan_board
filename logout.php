<?php
session_start();

$_SESSION = [];
header('Location: /vantan_board/index.php');
exit;
