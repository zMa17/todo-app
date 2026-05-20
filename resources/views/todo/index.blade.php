<x-app-layout>
    <div class="px-8 py-8">
        @php
            $title = 'Upcoming';
            if (request('filter') === 'today') $title = 'Today';
            elseif (request('filter') === 'completed') $title = 'Completed';
            elseif (request('kategori')) $title = $kategoris->firstWhere('id', request('kategori'))?->nama ?? 'Kategori';
            elseif (request('tag')) $title = $tags->firstWhere('id', request('tag'))?->nama ?? 'Tag';
        @endphp

        <div class="flex items-center mb-6">
            <h1 style="font-size:32px;font-weight:700" class="flex-1">{{ $title }}</h1>
            <span class="px-2 py-0.5 bg-gray-100 text-gray-400">{{ $todos->count() }}</span>
        </div>

        <a href="{{ route('todo.create') }}" class="flex px-4 py-3 border mb-6 text-gray-400" style="text-decoration:none">+ Add New Task</a>

        @foreach ($activeTodos as $todo)
            <div class="flex px-4 py-3 border-b">
                <div class="mr-3">
                    <form action="{{ route('todo.update', $todo) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="judul" value="{{ $todo->judul }}">
                        <input type="hidden" name="deskripsi" value="{{ $todo->deskripsi }}">
                        <input type="hidden" name="tanggal_deadline" value="{{ $todo->tanggal_deadline->format('Y-m-d') }}">
                        <input type="hidden" name="prioritas" value="{{ $todo->prioritas }}">
                        <input type="hidden" name="kategori_id" value="{{ $todo->kategori_id }}">
                        @foreach ($todo->tags as $tag)
                            <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                        @endforeach
                        <button type="submit" name="is_completed" value="1" style="background:none;border:none;padding:0">
                            <div class="w-5 h-5 border-2 border-gray-300"></div>
                        </button>
                    </form>
                </div>
                <div class="flex-1">
                    <div>{{ $todo->judul }}</div>
                    <div class="flex mt-1">
                        @if ($todo->tanggal_deadline)
                            <span class="mr-2 text-gray-400" style="font-size:12px">{{ $todo->tanggal_deadline->format('M d') }}</span>
                        @endif
                        @if ($todo->kategori)
                            <span class="mr-2 text-gray-500" style="font-size:12px">
                                <span class="w-2 h-2 inline-block mr-1" style="background:{{ $todo->kategori->warna }};border-radius:50%"></span>
                                {{ $todo->kategori->nama }}
                            </span>
                        @endif
                        @foreach ($todo->tags as $tag)
                            <span class="mr-1 px-2 py-0.5" style="font-size:11px;background:{{ $tag->warna }}20;color:{{ $tag->warna }}">{{ $tag->nama }}</span>
                        @endforeach
                        @if ($todo->prioritas === 'high')
                            <span class="text-red-500" style="font-size:12px">High</span>
                        @elseif ($todo->prioritas === 'medium')
                            <span class="text-amber-500" style="font-size:12px">Medium</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300" style="text-decoration:none">></a>
            </div>
        @endforeach

        @if ($completedTodos->count() > 0 && request('filter') !== 'completed')
            <div class="flex items-center px-4 py-3">
                <hr class="flex-1" style="border-color:#ddd">
                <span class="px-3 text-gray-400" style="font-size:12px">Completed</span>
                <hr class="flex-1" style="border-color:#ddd">
            </div>
            @foreach ($completedTodos as $todo)
                <div class="flex px-4 py-3 border-b">
                    <div class="mr-3">
                        <form action="{{ route('todo.update', $todo) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="judul" value="{{ $todo->judul }}">
                            <input type="hidden" name="deskripsi" value="{{ $todo->deskripsi }}">
                            <input type="hidden" name="tanggal_deadline" value="{{ $todo->tanggal_deadline->format('Y-m-d') }}">
                            <input type="hidden" name="prioritas" value="{{ $todo->prioritas }}">
                            <input type="hidden" name="kategori_id" value="{{ $todo->kategori_id }}">
                            @foreach ($todo->tags as $tag)
                                <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                            @endforeach
                            <button type="submit" name="is_completed" value="0" style="background:none;border:none;padding:0">
                                <div class="w-5 h-5 border-2 bg-amber-400 border-amber-400" style="display:flex;align-items:center;justify-content:center">&#10003;</div>
                            </button>
                        </form>
                    </div>
                    <div class="flex-1">
                        <div style="text-decoration:line-through;color:#999">{{ $todo->judul }}</div>
                        <div class="flex mt-1">
                            @if ($todo->tanggal_deadline)
                                <span class="mr-2 text-gray-400" style="font-size:12px">{{ $todo->tanggal_deadline->format('M d') }}</span>
                            @endif
                            @if ($todo->kategori)
                                <span class="mr-2 text-gray-400" style="font-size:12px">
                                    <span class="w-2 h-2 inline-block mr-1" style="background:{{ $todo->kategori->warna }};border-radius:50%"></span>
                                    {{ $todo->kategori->nama }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300" style="text-decoration:none">></a>
                </div>
            @endforeach
        @endif

        @if ($todos->isEmpty() && request('filter') !== 'completed')
            <div class="text-center py-16 text-gray-400">Belum ada todo.</div>
        @endif
    </div>
</x-app-layout>