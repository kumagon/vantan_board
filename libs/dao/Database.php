<?php

abstract class Database
{
    /** @var PDO  */
    public $pdo;

    public function __construct()
    {
        $DBSERVER = 'localhost';
        $DBUSER = 'board';
        $DBPASSWD = 'boardpw';
        $DBNAME = 'board';

        $dsn = 'mysql:'
            . 'host=' . $DBSERVER . ';'
            . 'dbname=' . $DBNAME . ';'
            . 'charset=utf8';
        $this->pdo = new PDO($dsn, $DBUSER, $DBPASSWD, array(PDO::ATTR_EMULATE_PREPARES => false));
    }
}
