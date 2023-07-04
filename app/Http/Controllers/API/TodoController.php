<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $todo = Todo::create($validatedData);

        return response()->json($todo, Response::HTTP_CREATED);
    }

    public function show(Todo $todo)
    {
        return response()->json($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $todo->update($validatedData);

        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
