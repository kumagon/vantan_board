<?php

class BoardEntity
{

    public $id;
    public $title;
    public $userId;
    public $createdAt;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->userId = $data['userId'];
        $this->createdAt = $data['createdAt'];
    }
}
