<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::get();
        return response()->json($tasks);  
    }

    public function show(Task $id){
        return response()->json($id);
    }
}
