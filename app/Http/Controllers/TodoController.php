<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Kategori;
use App\Models\Tag;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::with(['kategori', 'tags']);

        if ($request->filter === 'today') {
            $query->whereDate('tanggal_deadline', today());
        } elseif ($request->filter === 'completed') {
            $query->where('is_completed', true);
        } elseif ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        } elseif ($request->tag) {
            $query->whereHas('tags', fn($q) => $q->where('id', $request->tag));
        }

        $todos = $query->get();
        $activeTodos = $todos->where('is_completed', false);
        $completedTodos = $todos->where('is_completed', true);
        $kategoris = Kategori::all();
        $tags = Tag::all();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('todo._list', compact('activeTodos', 'completedTodos', 'todos', 'kategoris', 'tags'))->render(),
                'count' => $todos->count(),
            ]);
        }

        return view('todo.index', compact('todos', 'activeTodos', 'completedTodos', 'kategoris', 'tags'));
    }

    public function create()
    {
        $todos = Todo::with(['kategori', 'tags'])->get();
        $kategoris = Kategori::all();
        $tags = Tag::all();
        return view('todo.create', compact('todos', 'kategoris', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required',
            'deskripsi'        => 'required',
            'tanggal_deadline' => 'required|date',
            'prioritas'        => 'required',
            'kategori_id'      => 'required',
            'tags'             => 'required|array',
        ]);

        $todo = Todo::create([
            'kategori_id'      => $request->kategori_id,
            'judul'            => $request->judul,
            'deskripsi'        => $request->deskripsi,
            'tanggal_deadline' => $request->tanggal_deadline,
            'prioritas'        => $request->prioritas,
            'is_completed'     => $request->is_completed ?? false,
        ]);

        $todo->tags()->sync($request->tags);

        return redirect()->route('todo.index');
    }

    public function edit(string $id)
    {
        $todo = Todo::with(['kategori', 'tags'])->findOrFail($id);
        $todos = Todo::with(['kategori', 'tags'])->get();
        $kategoris = Kategori::all();
        $tags = Tag::all();
        return view('todo.edit', compact('todo', 'todos', 'kategoris', 'tags'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'judul'            => 'sometimes|required',
            'deskripsi'        => 'sometimes|required',
            'tanggal_deadline' => 'sometimes|required|date',
            'prioritas'        => 'sometimes|required',
            'kategori_id'      => 'sometimes|required',
            'tags'             => 'sometimes|required|array',
        ]);

        $data = $request->only(['kategori_id', 'judul', 'deskripsi', 'tanggal_deadline', 'prioritas']);
        if ($request->has('is_completed')) {
            $data['is_completed'] = $request->is_completed;
        }
        $todo->update($data);

        if ($request->has('tags')) {
            $todo->tags()->sync($request->tags);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('todo.index');
    }

    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return redirect()->route('todo.index')->with('success', 'Todo berhasil dihapus');
    }
}
