<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../entity/BoardEntity.php';

class BoardDao extends Database
{

    /**
     * 掲示板を作成する
     * @param $title
     * @return bool|string
     */
    public function insert($title)
    {
        $sql = 'INSERT INTO `boards` (title, created, modified)';
        $sql .= ' VALUES (:title, NOW(), NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':title', $title, \PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result) {
            return $this->pdo->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * 掲示板を取得する
     * @return array
     */
    public function findAll()
    {
        $sql = 'SELECT * FROM `boards` ORDER BY id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $boardList = [];
        foreach ($stmt->fetchAll() as $data) {
            $boardList[] = new BoardEntity($data);
        }
        return $boardList;
    }

    /**
     * 指定したIDの掲示板取得する
     * @param $id
     * @return null|BoardEntity
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM `boards` WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch();
        return empty($data) ? null : new BoardEntity($data);
    }
}
