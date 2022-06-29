<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../entity/UserEntity.php';

class UserDao extends Database
{
    public function findByEmail($email) {
        $sql = 'SELECT * FROM `users` WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch();
        return empty($data) ? null : new UserEntity($data);
    }
}
