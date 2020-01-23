<?php

// Routes

$app->get('/', function ($request, $response, $args) {
    $endpoints = [
        'all tasks' => $this->api['api_url'] . '/tasks',
        'single task' => $this->api['api_url'] . '/tasks/{task_id}',
        'subtasks of task' => $this->api['api_url'] . '/tasks/{task_id}/subtasks',
        'single subtask' => $this->api['api_url'] . '/tasks/{task_id}/subtasks/{subtask_id}',
        'help' => $this->api['base_url'] . '/'
    ];
    $result = [
        'endpoints' => $endpoints,
        'version' => $this->api['version'],
        'timestamp' => time()
    ];
    return $response->withJson($result, 200, JSON_PRETTY_PRINT);
});

$app->group('/api/v1/tasks', function () use ($app) {
    $app->get('', function ($request, $response, $args) {
        $result = $this->task->getTasks();
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
    $app->get('/{task_id}', function ($request, $response, $args) {
        $result = $this->task->getTask($args['task_id']);
        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    });
    $app->group('/{task_id}/subtasks', function () use ($app) {
        $app->get('', function ($request, $response, $args) {
            $result = $this->subtask->getSubtasksByTaskId($args['task_id']);
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
        $app->get('/{subtask_id}', function ($request, $response, $args) {
            $result = $this->subtask->getSubtask($args['subtask_id']);
            return $response->withJson($result, 200, JSON_PRETTY_PRINT);
        });
    });
});
