<?php

namespace App\Model;

class Subtask
{
    protected $database;
    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function getSubtasksByTaskId($task_id)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM subtasks WHERE task_id = :task_id ORDER BY id'
        );
        $statement->bindParam('task_id', $task_id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getSubtask($subtask_id)
    {
        $statement = $this->database->prepare(
            'SELECT * FROM subtasks WHERE id = :id'
        );
        $statement->bindParam('id', $subtask_id);
        $statement->execute();
        return $statement->fetch();
    }

    public function createSubtask($data)
    {
        $statement = $this->database->prepare(
            'INSERT INTO subtasks (name, status, task_id) VALUES (:name, :status, :task_id)'
        );
        $statement->bindParam('name', $data['name']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('task_id', $data['task_id']);
        $statement->execute();
        return $this->getSubtask($this->database->lastInsertId());
    }

    public function updateSubtask($data)
    {
        $statement = $this->database->prepare(
            'UPDATE subtasks SET name = :name, status = :status WHERE id = :id'
        );
        $statement->bindParam('name', $data['name']);
        $statement->bindParam('status', $data['status']);
        $statement->bindParam('id', $data['subtask_id']);
        $statement->execute();
        return $this->getSubtask($data['subtask_id']);
    }

    public function deleteSubtask($subtask_id)
    {
        $statement = $this->database->prepare(
            'DELETE FROM subtasks WHERE id = :id'
        );
        $statement->bindParam('id', $subtask_id);
        $statement->execute();
        return ['message' => 'The subtask was deleted.'];
    }
}
