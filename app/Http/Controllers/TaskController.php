<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::get();
        return response()->json($tasks);  
    }

    public function show(Task $id){
        return response()->json($id);
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => ['required','string','max:255'],
            'status' => ['required','string']
        ]);

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $validate['title'],
            'status' => $validate['status']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'تم إضافة التاسك بنجاح',
            'data' => $task
        ]);
    }

    public function update(Request $request, $id)
{
    $validate = $request->validate([
        'title'  => ['required','string','max:255'],
        'status' => ['required','string','max:255'],
    ]);

    $task = Task::where('id', $id)
        ->where('user_id', auth()->id())
        ->first();

    if (!$task) {
        return response()->json([
            'status' => false,
            'message' => 'Task not found'
        ]);
    }

    $task->update([
        'title'  => $validate['title'],
        'status' => $validate['status'],
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Task updated successfully',
        'data' => $task
    ]);
}

public function delete($id)
    {
        $task = Task::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task غير موجودة'
            ]);
        }

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'تم حذف التاسك بنجاح'
        ]);
    }

}
