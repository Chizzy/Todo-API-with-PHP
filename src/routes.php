<?php

// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    $result = $this->task->getTasks();
    return $response->withJson($result, 200, JSON_PRETTY_PRINT);
});
