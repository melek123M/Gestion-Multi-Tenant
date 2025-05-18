<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Tenant;
use App\Http\Requests\Api\AssignTaskAPIRequest;


class TaskController extends Controller
{
    public function myTasks(Request $request)
    {
        $user = $request->user();

        $tasks = $user->assignedTasks()->with('project')->get();

        return response()->json($tasks);
    }

    public function markComplete(Request $request, Task $task)
    {
        if (Tenant::current() && $task->project->tenant_id !== Tenant::current()->id) {
            return response()->json(['message' => 'Task not found for this tenant.'], 404);
        }

        $task->status = 'completed';
        $task->save();

        return response()->json(['message' => 'Task marked as complete.', 'task' => $task]);
    }

    public function assignTask(AssignTaskAPIRequest $request, Task $task)
    {
        $user = User::find($request->user_id);

        if (Tenant::current() && $user->tenant_id !== Tenant::current()->id) {
            return response()->json(['message' => 'Assigned user does not belong to this tenant.'], 403);
        }

        // Vérifiez si la tâche appartient au projet du locataire courant
        if (Tenant::current() && $task->project->tenant_id !== Tenant::current()->id) {
            return response()->json(['message' => 'Task not found for this tenant.'], 404);
        }

        // Le middleware 'can:assign tasks' doit être sur la route pour cette méthode.
        // Exemple de vérification manuelle dans le contrôleur:
        // if ($request->user()->cannot('assign tasks')) {
        //     return response()->json(['message' => 'You are not authorized to assign tasks.'], 403);
        // }

        $task->assigned_to_user_id = $request->user_id;
        $task->save();

        return response()->json(['message' => 'Task assigned successfully.', 'task' => $task]);
    }

    // Exemple: Méthode de mise à jour pour les tâches (requiert la permission 'edit tasks')
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'due_date' => 'sometimes|date',
        ]);

        // Vérifiez si la tâche appartient au projet du locataire courant
        if (Tenant::current() && $task->project->tenant_id !== Tenant::current()->id) {
            return response()->json(['message' => 'Task not found for this tenant.'], 404);
        }

        // Le middleware 'can:edit tasks' doit être sur la route pour cette méthode.
        $task->update($request->all());

        return response()->json(['message' => 'Task updated successfully.', 'task' => $task]);
    }
}