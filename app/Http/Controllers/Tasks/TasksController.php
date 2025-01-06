<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use Exception;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return response(['tasks' => $tasks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**Validate fields */
        $fields = $request->validate([
            'task_name' => 'required|string|min:3',
            'description' => 'required|string|min:8',
            'priority' => 'required|integer',
        ]);

        /**Add the task to db */
        $task = new Task();
        $result = $task->addTask($fields);

        /**Handle error */
        if (empty($result)) {
            return response([
                'message' => 'Something went wrong, try again later',
            ], 500);
        }

        /**Return response */
        return response([
            'message' => 'Task was added successfully',
            "task" => $result,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**Instantiate task model */
        $task = new Task();

        /** Get the task and catch 404 error*/
        try {
            $taskResult = $task->getTask($id);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        return response([
            'message' => 'successfull',
            'task' => $taskResult
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**Validate the input form */
        try {
            /**Validate fields */
            $fields = $request->validate([
                'task_name' => 'required|string|min:3',
                'description' => 'required|string|min:8',
                'priority' => 'required|integer',
            ]);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        /**Instantiate task model */
        $task = new Task();

        /** Update the task */
        $taskResult = $task->updateTask($fields, $id);

        /**Handle error */
        if (empty($taskResult)) {
            return response([
                'message' => 'Something went wrong, try again later',
            ], 500);
        }
        /**Return response */
        return response([
            'message' => 'Task updated successfully',
            "task" => $taskResult,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**Delete the task from db */
        $task = new Task();

        /**Delete the task from db */
        try {
            $deletedTask = $task->deleteTask($id);
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        /**Return response */
        return response([
            'message' => 'Task was deleted successfully',
            "task" => $deletedTask,
        ]);
    }
}
