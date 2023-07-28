<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // declare all controller handler function here

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // method to validate the request inputs
    public function isInputValid(): bool
    {
        return $this->request->validate([
            "name" => "required",
            "desc" => "required"
        ]) ? true: false;
    }

    // handler to create a task
    public function createTask()
    {
        try {
            $this->isInputValid();
            $task = Task::create($this->request->input());
            return response()->json([
                "status" => "success",
                "msg" => "Task created successfully",
                "data" => $task
            ]);
        }catch(\Exception $ex) {
            return response()->json([
                "status" => "failed",
                "msg" => "{$ex->getMessage()}",
                "data" => []
            ]);
        }
    }

    public function getTasks()
    {
        try {
            $tasks = Task::all();
            return response()->json([
                "status" => "success",
                "msg" => "Task fetched successfully",
                "data" => $tasks
            ]);
        }catch(\Exception $ex) {
            return response()->json([
                "status" => "failed",
                "msg" => "{$ex->getMessage()}",
                "data" => []
            ]);
        }
    }

    public function updateTask($task)
    {
        try {
            $this->isInputValid();
            $name = $this->request->name;
            $desc = $this->request->desc;
            $task = Task::find($task);
            $task->update(["name" => $name, "desc" => $desc]);
            return response()->json([
                "status" => "success",
                "msg" => "Task updated successfully"
            ]);
        }catch(\Exception $ex) {
            return response()->json([
                "status" => "failed",
                "msg" => "{$ex->getMessage()}"
            ]);
        }
    }

    public function deleteTask($task)
    {
        try {
            $task = Task::find($task);
            $task->delete();
            return response()->json([
                "status" => "success",
                "msg" => "Task deleted successfully",
            ]);
        }catch(\Exception $ex) {
            return response()->json([
                "status" => "failed",
                "msg" => "{$ex->getMessage()}",
            ]);
        }
    }
}
