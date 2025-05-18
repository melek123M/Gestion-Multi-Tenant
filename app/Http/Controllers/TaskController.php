<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index() {}
    public function create() {}
    public function store(Request $request) {}
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}

    public function myTasks(Request $request)
    {
        return $request->user()->tasks;
    }

    public function markComplete(Task $task)
    {
        $this->authorize('update', $task);
        $task->update(['status' => 'completed']);
        return response()->json(['message' => 'Tâche terminée']);
    }
}