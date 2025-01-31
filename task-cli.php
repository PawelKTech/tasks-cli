<?php
require_once "src/taskFunctions.php";
require_once "src/TaskFunctions.php";

function showUsage($message = "")
{
    if ($message) {
        echo $message . "\n";
    }
    echo "Usage: php task-cli.php <command> [options]\n";
    exit(1);
}

function getNumericArgument($index)
{
    global $argv;
    return isset($argv[$index]) && is_numeric($argv[$index]) ? $argv[$index] : null;
}

if ($argc < 2) {
    showUsage("Error: No command provided.");
}

$command = $argv[1];
$options = isset($argv[2]) ? $argv[2] : null;

$commands = [
    "list" => function () use ($options) {
        if ($options !== null) {
            if (is_numeric($options)) {
                findTask($options);
            } else {
                showProgressList($options);
            }
        } else {
            listTasks();
        }
    },
    "add" => function () use ($options) {
        if ($options) {
            addTask($options);
        } else {
            showUsage("Error: Task description is required.");
        }
    },
    "delete" => function () use ($options) {
        $taskId = getNumericArgument(2);
        if ($taskId) {
            deleTask($taskId);
        } else {
            showUsage("Error: Task ID is required.");
        }
    },
    "edit" => function () use ($options) {
        if (isset($argv[2]) && isset($argv[3])) {
            editTask($argv[2], $argv[3]);
        } else {
            showUsage("Error: Both task ID and new description are required.");
        }
    },
    "mark-in-progress" => function () use ($options) {
        $taskId = getNumericArgument(2);
        if ($taskId) {
            setInProgress($taskId);
        } else {
            showUsage("Error: Task ID is required.");
        }
    },
    "mark-done" => function () use ($options) {
        $taskId = getNumericArgument(2);
        if ($taskId) {
            setDone($taskId);
        } else {
            showUsage("Error: Task ID is required.");
        }
    },

    "mark-to-do" => function () use ($options) {
        $taskId = getNumericArgument(2);
        if ($taskId) {
            setToDo($taskId);
        } else {
            showUsage("Error: Task ID is required.");
        }
    },

    "clear" => function () use ($options) {
        clear();
    }
];

if (array_key_exists($command, $commands)) {
    $commands[$command]();
} else {
    showUsage("Error: Invalid command.");
}
