<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\Kategori;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::where('user_id', auth()->id());

        if ($request->kategori_id) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->tag_id) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tag_id', $request->tag_id);
            });
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        if ($request->prioritas) {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->has('is_completed') && $request->is_completed !== '') {
            $query->where('is_completed', $request->is_completed);
        }

        if ($request->deadline_from) {
            $query->whereDate('tanggal_deadline', '>=', $request->deadline_from);
        }

        if ($request->deadline_to) {
            $query->whereDate('tanggal_deadline', '<=', $request->deadline_to);
        }

        $todos = $query->with(['kategori', 'tags'])->get();
        $kategoris = Kategori::withCount('todos')->get();
        $tags = Tag::withCount('todos')->get();

        return view('dashboard', compact('todos', 'kategoris', 'tags'));
    }
}
