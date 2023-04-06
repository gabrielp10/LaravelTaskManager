<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = [
            [
                'label' => 'To-do',
                'value' => 'To-do',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',        
            ]
        ];

        return view('create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'nullable',
        ]);

        Task::create($data);

        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        $statuses = [
            [
                'label' => 'To-do',
                'value' => 'To-do',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',        
            ]
        ];

        return view('edit', compact('statuses', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'nullable',
        ]);

        $task->update($data);

        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['status' => 'success']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $tasks = Task::where('title', 'like', '%' . $query . '%')
        ->orWhere('description', 'like', '%' . $query . '%')
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($task) {
            $task->created_at_formatted = $task->created_at->diffForHumans();
            $task->updated_at_formatted = $task->updated_at->diffForHumans();
            return $task;
        });

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    public function searchTask(Request $request)
    {
        $query = $request->query('query');
    
        if ($query) {
            $tasks = Task::where('title', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%')
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($task) {
                    $task->created_at_formatted = $task->created_at->diffForHumans();
                    $task->updated_at_formatted = $task->updated_at->diffForHumans();
                    return $task;
                });
        } else {
            $tasks = Task::orderBy('id', 'desc')
                ->get()
                ->map(function ($task) {
                    $task->created_at_formatted = $task->created_at->diffForHumans();
                    $task->updated_at_formatted = $task->updated_at->diffForHumans();
                    return $task;
                });
        }
    
        return response()->json([
            'tasks' => $tasks,
        ]);
    }
}
