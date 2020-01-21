<?php

namespace App\Model;

class Task
{
    protected $database;
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function getTasks()
    {
        $statement = $this->database->query(
            'SELECT * FROM tasks ORDER BY id'
        );
        return $statement->fetchAll();
    }

    public function getTask($task_id)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM tasks WHERE id = :id'
        );
        $statement->bindParam('id', $task_id);
        $statement->execute();
        return $statement->fetch();
    }
    
    public function createTask($data)
    {
        $statement = $this->database->prepare(
            'INSERT INTO tasks (task, status) VALUES (:task, :status)'
        );
        $statement->bindParam('task', $data['task']);
        $statement->bindParam('status', $data['status']);
        $statement->execute();
        return $this->getTask($this->database->lastInsertId());
    }
}
