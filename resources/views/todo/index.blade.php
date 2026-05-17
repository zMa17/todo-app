<x-app-layout>
    <div class="px-8 py-8">
        @php
            $title = 'Semua Todo';
            if (request('filter') === 'today') $title = 'Today';
            elseif (request('filter') === 'completed') $title = 'Completed';
            elseif (request('kategori')) {
                $kat = $kategoris->firstWhere('id', request('kategori'));
                $title = $kat ? $kat->nama : 'Kategori';
            } elseif (request('tag')) {
                $t = $tags->firstWhere('id', request('tag'));
                $title = $t ? $t->nama : 'Tag';
            }
        @endphp

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-900">{{ $title }}</h1>
            <span class="text-sm text-gray-400 bg-gray-100 px-2.5 py-0.5 rounded-full">{{ $todos->count() }}</span>
        </div>

        <a href="{{ route('todo.create') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-400 border border-[#e5e5e4] rounded-lg hover:border-gray-300 hover:text-gray-500 transition-colors mb-6">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Task
        </a>

        <div class="space-y-0">
            @forelse ($activeTodos as $todo)
                <div class="flex items-start gap-3 px-4 py-3 border-b border-[#e5e5e4] hover:bg-gray-50 transition-colors rounded-lg -mx-4">
                    <div class="pt-0.5">
                        <form action="{{ route('todo.update', $todo) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="judul" value="{{ $todo->judul }}">
                            <input type="hidden" name="deskripsi" value="{{ $todo->deskripsi }}">
                            <input type="hidden" name="tanggal_deadline" value="{{ $todo->tanggal_deadline->format('Y-m-d') }}">
                            <input type="hidden" name="prioritas" value="{{ $todo->prioritas }}">
                            <input type="hidden" name="kategori_id" value="{{ $todo->kategori_id }}">
                            @foreach ($todo->tags as $tag)
                                <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                            @endforeach
                            <button type="submit" name="is_completed" value="1">
                                <div class="w-5 h-5 rounded border-2 border-gray-300 flex items-center justify-center hover:border-amber-400 transition-colors"></div>
                            </button>
                        </form>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $todo->judul }}</p>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            @if ($todo->tanggal_deadline)
                                <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $todo->tanggal_deadline->format('M d') }}
                                </span>
                            @endif

                            @if ($todo->kategori)
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $todo->kategori->warna }}"></span>
                                    {{ $todo->kategori->nama }}
                                </span>
                            @endif

                            @foreach ($todo->tags as $tag)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $tag->warna }}20; color: {{ $tag->warna }}">
                                    {{ $tag->nama }}
                                </span>
                            @endforeach

                            @if ($todo->prioritas === 'high')
                                <span class="inline-flex items-center gap-1 text-xs text-red-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                    High
                                </span>
                            @elseif ($todo->prioritas === 'medium')
                                <span class="inline-flex items-center gap-1 text-xs text-amber-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                    </svg>
                                    Medium
                                </span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300 hover:text-gray-500 transition-colors pt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @empty
                @if (request('filter') !== 'completed')
                    <div class="text-center py-16">
                        <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-gray-400 text-sm">Belum ada todo.</p>
                    </div>
                @endif
            @endforelse

            @if ($completedTodos->count() > 0 && request('filter') !== 'completed')
                <div class="relative flex items-center gap-4 py-4 -mx-4 px-4">
                    <div class="flex-1 border-t border-[#e5e5e4]"></div>
                    <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Completed</span>
                    <div class="flex-1 border-t border-[#e5e5e4]"></div>
                </div>

                @foreach ($completedTodos as $todo)
                    <div class="flex items-start gap-3 px-4 py-3 border-b border-[#e5e5e4] hover:bg-gray-50 transition-colors rounded-lg -mx-4">
                        <div class="pt-0.5">
                            <form action="{{ route('todo.update', $todo) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul" value="{{ $todo->judul }}">
                                <input type="hidden" name="deskripsi" value="{{ $todo->deskripsi }}">
                                <input type="hidden" name="tanggal_deadline" value="{{ $todo->tanggal_deadline->format('Y-m-d') }}">
                                <input type="hidden" name="prioritas" value="{{ $todo->prioritas }}">
                                <input type="hidden" name="kategori_id" value="{{ $todo->kategori_id }}">
                                @foreach ($todo->tags as $tag)
                                    <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                                @endforeach
                                <button type="submit" name="is_completed" value="0">
                                    <div class="w-5 h-5 rounded border-2 bg-amber-400 border-amber-400 flex items-center justify-center hover:bg-amber-500 hover:border-amber-500 transition-colors">
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </button>
                            </form>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm line-through text-gray-400">{{ $todo->judul }}</p>
                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                @if ($todo->tanggal_deadline)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $todo->tanggal_deadline->format('M d') }}
                                    </span>
                                @endif

                                @if ($todo->kategori)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $todo->kategori->warna }}"></span>
                                        {{ $todo->kategori->nama }}
                                    </span>
                                @endif

                                @foreach ($todo->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $tag->warna }}10; color: {{ $tag->warna }}80">
                                        {{ $tag->nama }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300 hover:text-gray-500 transition-colors pt-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>