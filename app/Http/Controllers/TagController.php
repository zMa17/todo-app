<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('tag.index', compact('tags'));
    }

    public function create()
    {
        return view('tag.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'warna' => 'required',
            'nama' => 'required',
        ]);

        Tag::create([
            'warna' => $request->warna,
            'nama' => $request->nama,
        ]);

        return redirect()->route('tag.index')->with('success', 'Tag berhasil dibuat.');
    }

    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);
        return view('tag.edit', compact('tag'));
    }

    public function update(Request $request, string $id)
    {
        $tag = Tag::findOrFail($id);

        $request->validate([
            'warna' => 'required',
            'nama' => 'required',
        ]);

        $tag->update([
            'warna' => $request->warna,
            'nama' => $request->nama,
        ]);

        return redirect()->route('tag.index')->with('success', 'Tag berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('tag.index')->with('success', 'Tag berhasil dihapus.');
    }
}
