<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        try {
            $tasks = Task::all();
            return view('tasks.index', ['tasks' => $tasks]);
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'An error occurred while fetching tasks.');
        }
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'due_date' => 'required|date',
                'due_time' => 'required'
            ]);

            Task::create($validatedData);

            return redirect()->route('tasks.index')
                           ->with('success', 'Task created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'An error occurred while creating the task.');
        }
    }

    public function edit($id)
    {
        try {
            $task = Task::findOrFail($id);
            return view('tasks.edit', ['task' => $task]);
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Task not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);
            
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'due_date' => 'required|date',
                'due_time' => 'required'
            ]);

            $task->update($validatedData);

            return redirect()->route('tasks.index')
                           ->with('success', 'Task updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'An error occurred while updating the task.');
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            
            return redirect()->route('tasks.index')
                           ->with('success', 'Task deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'An error occurred while deleting the task.');
        }
    }
}