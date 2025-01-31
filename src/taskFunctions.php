<?php
require_once "fileFunctions.php";

function listTasks()
{
    $tasks = loadTasks();

    if (empty($tasks)) {
        echo "No tasks found. \n";
        return;
    }

    echo "+----+----------------------------+---------------------+\n";
    echo "| ID | Description                | Status              |\n";
    echo "+----+----------------------------+---------------------+\n";

    foreach ($tasks as $task) {
        printf(
            "| %-2s | %-26s | %-19s |\n",
            $task['id'],
            str_pad(substr($task['description'], 0, 26), 26),
            $task['status']
        );
    }

    echo "+----+----------------------------+---------------------+\n";
}



function findTask($id)
{
    $id--;
    $tasks = loadTasks();

    if (empty($tasks)) {
        echo "No tasks found. \n";
        return;
    }

    if (!isset($tasks[$id])) {
        echo "Task with ID " . ($id + 1) . "not found.\n";
        return;
    }

    echo "+----+----------------------------+---------------------+\n";
    echo "| ID | Description                | Status              |\n";
    echo "+----+----------------------------+---------------------+\n";

    printf(
        "| %-2s | %-26s | %-19s |\n",
        $tasks[$id]['id'],
        str_pad(substr($tasks[$id]['description'], 0, 26), 26),
        $tasks[$id]['status']
    );
    echo "+----+----------------------------+---------------------+\n";
}


function addTask($text)
{
    $tasks = loadTasks();

    $newID = count($tasks) > 0 ? max(array_column($tasks, 'id')) + 1 : 1;

    $newTask = [
        "id" => $newID,
        "description" => $text,
        "status" => "to-do",
    ];

    $tasks[] = $newTask;

    saveTasks($tasks);
    echo "Task added successfully (ID: {$newID})\n";
}


function deleTask($id)
{
    $tasks = loadTasks();

    $index = array_search($id, array_column($tasks, 'id'));

    if ($index !== false) {
        array_splice($tasks, $index, 1);
        saveTasks($tasks);
        echo "Task with ID {$id} has been deleted successfully.\n";
    } else {
        echo "Task of this ID does not exist.\n";
    }
}


function editTask($newText, $id)
{
    $tasks = loadTasks();

    $index = array_search($id, array_column($tasks, 'id'));

    if ($index !== false) {
        $tasks[$index]['description'] = $newText;
        saveTasks($tasks);
        echo "Task with ID {$id} has been updated successfully.\n";
    } else {
        echo "Task of this ID does not exist.\n";
    }
}

function setInProgress($id)
{
    $tasks = loadTasks();

    $index = array_search($id, array_column($tasks, 'id'));

    if ($index !== false) {
        $tasks[$index]['status'] = "in-progress";
        saveTasks($tasks);
        echo "Task with ID {$id} is now in progress.\n";
    } else {
        echo "Task of this ID does not exist.\n";
    }
}

function setDone($id)
{
    $tasks = loadTasks();

    $index = array_search($id, array_column($tasks, 'id'));

    if ($index !== false) {
        $tasks[$index]['status'] = "done";
        saveTasks($tasks);
        echo "Task with ID {$id} is now in progress.\n";
    } else {
        echo "Task of this ID does not exist.\n";
    }
}

function setToDo($id)
{
    $tasks = loadTasks();

    $index = array_search($id, array_column($tasks, 'id'));

    if ($index !== false) {
        $tasks[$index]['status'] = "to-do";
        saveTasks($tasks);
        echo "Task with ID {$id} is now in progress.\n";
    } else {
        echo "Task of this ID does not exist.\n";
    }
}

function showProgressList($status)
{
    $tasks = loadTasks();
    $ListOfstatus = ["to-do", "in-progress", "done"];

    if (in_array($status, $ListOfstatus)) {
        $toDoTasks = array_filter($tasks, function ($task) use ($status) {
            return $task['status'] === $status;
        });

        echo "+----+----------------------------+---------------------+\n";
        echo "| ID | Description                | Status              |\n";
        echo "+----+----------------------------+---------------------+\n";

        foreach ($toDoTasks as $task) {
            printf(
                "| %-2s | %-26s | %-19s |\n",
                $task['id'],
                str_pad(substr($task['description'], 0, 26), 26),
                $task['status']
            );
        }

        echo "+----+----------------------------+---------------------+\n";
    } else {
        echo "Error: Unknown task";
    }
}

function clear()
{
    $tasks = loadTasks();

    if (empty($tasks)) {
        echo "The list ist empty.";
    }

    saveTasks([]);

    echo "All tasks have been deleted successfully.\n";
}
