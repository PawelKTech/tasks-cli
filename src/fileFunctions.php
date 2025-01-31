<?php
define('TASKS_FILE', 'data/tasks.json');

function loadTasks()
{
    if (!file_exists(TASKS_FILE)) {
        file_put_contents(TASKS_FILE, json_encode([], JSON_PRETTY_PRINT));
        return [];
    }
    $data = file_get_contents(TASKS_FILE);
    return json_decode($data, true);
}


function saveTasks($task)
{
    $jsonData = json_encode($task, JSON_PRETTY_PRINT);
    file_put_contents(TASKS_FILE, $jsonData);
}
