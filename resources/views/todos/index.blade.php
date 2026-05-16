@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-medium">Todo List</h1>
        <a href="{{ route('todos.create') }}"
           class="inline-block px-5 py-1.5 dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] hover:bg-black hover:border-black bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
            + Buat Todo
        </a>
    </div>

    <div class="mb-6 p-4 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-sm">
        <form method="GET" action="{{ route('todos.index') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul..."
                       class="w-48 px-3 py-1.5 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]">
            </div>
            <div>
                <label class="block text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Status</label>
                <select name="status"
                        class="px-3 py-1.5 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Kategori</label>
                <select name="category_id"
                        class="px-3 py-1.5 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]">
                    <option value="">Semua</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Prioritas</label>
                <select name="priority"
                        class="px-3 py-1.5 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]">
                    <option value="">Semua</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Urutkan</label>
                <select name="sort"
                        class="px-3 py-1.5 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]"
                        onchange="this.form.submit()">
                    <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Deadline</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Prioritas</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul</option>
                </select>
            </div>
            <div>
                <label class="block text-xs mb-1 text-[#706f6c] dark:text-[#A1A09A]">Arah</label>
                <select name="order"
                        class="px-3 py-1.5 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]"
                        onchange="this.form.submit()">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Naik</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Turun</option>
                </select>
            </div>
            <div>
                <button type="submit"
                        class="px-4 py-1.5 text-sm border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:bg-[#1914000a] dark:hover:bg-[#fffaed0a]">
                    Filter
                </button>
            </div>
            @if(request()->anyFilled(['search', 'status', 'category_id', 'priority']))
                <div>
                    <a href="{{ route('todos.index') }}"
                       class="px-4 py-1.5 text-sm border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:bg-[#1914000a] dark:hover:bg-[#fffaed0a]">
                        Reset
                    </a>
                </div>
            @endif
        </form>
    </div>

    @if($todos->count() > 0)
        <div class="grid gap-4">
            @foreach($todos as $todo)
                <div class="p-5 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-sm {{ $todo->is_completed ? 'opacity-60' : '' }}">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <form action="{{ route('todos.toggle', $todo) }}" method="POST" class="mt-0.5 shrink-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-5 h-5 rounded-sm border-2 border-[#19140035] dark:border-[#3E3E3A] flex items-center justify-center transition-colors hover:border-[#f53003] dark:hover:border-[#FF4433] {{ $todo->is_completed ? 'bg-[#10b981] border-[#10b981] dark:bg-[#10b981] dark:border-[#10b981]' : '' }}">
                                    @if($todo->is_completed)
                                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </button>
                            </form>

                            <div class="min-w-0">
                                <h3 class="font-medium {{ $todo->is_completed ? 'line-through text-[#706f6c] dark:text-[#A1A09A]' : '' }}">{{ $todo->title }}</h3>
                                @if($todo->description)
                                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1 line-clamp-2">{{ $todo->description }}</p>
                                @endif

                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-sm"
                                          style="background-color: {{ $todo->category->color }}20; color: {{ $todo->category->color }}; border: 1px solid {{ $todo->category->color }}40">
                                        {{ $todo->category->name }}
                                    </span>

                                    @php
                                        $priorityColors = ['low' => ['text' => '#10b981', 'bg' => '#10b98120'], 'medium' => ['text' => '#f59e0b', 'bg' => '#f59e0b20'], 'high' => ['text' => '#ef4444', 'bg' => '#ef444420']];
                                        $pc = $priorityColors[$todo->priority];
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-sm"
                                          style="background-color: {{ $pc['bg'] }}; color: {{ $pc['text'] }}; border: 1px solid {{ $pc['text'] }}40">
                                        {{ ucfirst($todo->priority) }}
                                    </span>

                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-sm text-[#706f6c] dark:text-[#A1A09A] border border-[#19140035] dark:border-[#3E3E3A] {{ $todo->due_date->isPast() && !$todo->is_completed ? 'text-[#ef4444] dark:text-[#ef4444] border-[#ef4444]' : '' }}">
                                        📅 {{ $todo->due_date->format('d M Y') }}
                                    </span>

                                    @foreach($todo->tags as $tag)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs rounded-sm bg-[#f5300310] dark:bg-[#FF443310] text-[#f53003] dark:text-[#FF4433] border border-[#f5300320] dark:border-[#FF443320]">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('todos.edit', $todo) }}"
                               class="p-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            <form action="{{ route('todos.destroy', $todo) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus todo ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#ef4444] transition-colors"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $todos->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-sm">
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">Belum ada todo. Yuk buat todo pertama!</p>
            <a href="{{ route('todos.create') }}"
               class="inline-block px-5 py-1.5 dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] hover:bg-black hover:border-black bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
                + Buat Todo
            </a>
        </div>
    @endif
@endsection
