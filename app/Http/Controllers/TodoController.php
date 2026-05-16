<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Kategori;
use App\Models\Tag;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('todo.index', compact('todos'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $tags = Tag::all();
        return view('todo.create', compact('kategoris', 'tags'));
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
        $todo = Todo::findOrFail($id);
        $kategoris = Kategori::all();
        $tags = Tag::all();
        return view('todo.edit', compact('todo', 'kategoris', 'tags'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'judul'            => 'required',
            'deskripsi'        => 'required',
            'tanggal_deadline' => 'required|date',
            'prioritas'        => 'required',
            'kategori_id'      => 'required',
            'tags'             => 'required|array',
        ]);

        $todo->update([
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

    public function destroy(string $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return redirect()->route('todo.index')->with('success', 'Todo berhasil dihapus');
    }
}
