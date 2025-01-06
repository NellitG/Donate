<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**Get a task specified by Id */
    public function getTask($id)
    {
        $task = $this::findOrFail($id);
        return $task;
    }

    /**Add a task */
    public function addTask($fields)
    {
        $this->task_name = $fields['task_name'];
        $this->description = $fields['description'];
        $this->priority = $fields['priority'];
        /**Save task to db */
        $this->save();
        /**return result */
        return $this;
    }

    /**Update a task specified by Id */
    public function updateTask($fields, $id)
    {
        /**find task */
        $task = $this::findOrFail($id);

        /**Create variables */
        $task_name = $fields['task_name'] ?? null;
        $description = $fields['description'] ?? null;
        $priority = $fields['priority'] ?? null;

        /** Update fields if they exist in the $fields array */
        if (isset($task_name)) {
            $task->task_name = $task_name;
        }
        if (isset($description)) {
            $task->description = $description;
        }
        if (isset($priority)) {
            $task->priority = $priority;
        }

        /**Save task to db */
        $task->save();

        /**return result */
        return $task;
    }

    /**Delete a task specified by Id */
    public function deleteTask($id)
    {
        $task = $this::findOrFail($id);
        $task->delete();
        return $task;
    }
}
