<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StoreTodoRequest;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::with(['category', 'tags']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_completed', false);
            }
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $sortField = $request->get('sort', 'due_date');
        $sortOrder = $request->get('order', 'asc');
        $allowedSorts = ['due_date', 'created_at', 'priority', 'title'];
        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        $todos = $query->paginate(10)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all();

        return view('todos.index', compact('todos', 'categories', 'tags'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('todos.create', compact('categories', 'tags'));
    }

    public function store(StoreTodoRequest $request)
    {
        $todo = Todo::create($request->validated());

        if ($request->filled('tags')) {
            $todo->tags()->attach($request->tags);
        }

        return redirect()->route('todos.index')->with('success', 'Todo berhasil ditambahkan');
    }

    public function edit(Todo $todo)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('todos.edit', compact('todo', 'categories', 'tags'));
    }

    public function update(StoreTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());

        if ($request->filled('tags')) {
            $todo->tags()->sync($request->tags);
        } else {
            $todo->tags()->detach();
        }

        return redirect()->route('todos.index')->with('success', 'Todo berhasil diperbarui');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')->with('success', 'Todo berhasil dihapus');
    }

    public function toggle(Todo $todo)
    {
        $todo->update(['is_completed' => !$todo->is_completed]);

        return redirect()->back()->with('success', 'Status todo diperbarui');
    }
}
