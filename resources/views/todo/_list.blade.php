@foreach ($activeTodos as $todo)
    <div class="flex px-4 py-3 border-b" x-data="{ loading: false }">
        <div class="mr-3">
            <span @click="
                loading = true;
                fetch('{{ route('todo.update', $todo) }}', {
                    method: 'PUT',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        is_completed: 1,
                        judul: @json($todo->judul),
                        deskripsi: @json($todo->deskripsi),
                        tanggal_deadline: '{{ $todo->tanggal_deadline->format('Y-m-d') }}',
                        prioritas: '{{ $todo->prioritas }}',
                        kategori_id: {{ $todo->kategori_id }},
                        tags: {{ json_encode($todo->tags->pluck('id')->toArray()) }}
                    })
                }).then(r => r.json()).then(() => { loadTodos(window.location.href) })">
                <div class="w-5 h-5 border-2 border-gray-300 rounded" style="cursor:pointer"></div>
            </span>
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
                    <span class="mr-1 px-2 py-0.5 rounded-lg" style="font-size:11px;background:{{ $tag->warna }}20;color:{{ $tag->warna }}">{{ $tag->nama }}</span>
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
        <div class="flex px-4 py-3 border-b" x-data="{ loading: false }">
            <div class="mr-3">
                <span @click="
                    loading = true;
                    fetch('{{ route('todo.update', $todo) }}', {
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            is_completed: 0,
                            judul: @json($todo->judul),
                            deskripsi: @json($todo->deskripsi),
                            tanggal_deadline: '{{ $todo->tanggal_deadline->format('Y-m-d') }}',
                            prioritas: '{{ $todo->prioritas }}',
                            kategori_id: {{ $todo->kategori_id }},
                            tags: {{ json_encode($todo->tags->pluck('id')->toArray()) }}
                        })
                    }).then(r => r.json()).then(() => { loadTodos(window.location.href) })">
                    <div class="w-5 h-5 border-2 bg-amber-400 border-amber-400 rounded" style="display:flex;align-items:center;justify-content:center;cursor:pointer">&#10003;</div>
                </span>
            </div>
            <div class="flex-1">
                <div style="text-decoration:line-through;color:#999">{{ $todo->judul }}</div>
            </div>
            <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300" style="text-decoration:none">></a>
        </div>
    @endforeach
@endif

@if ($activeTodos->isEmpty() && request('filter') !== 'completed')
    <div class="text-center py-16 text-gray-400">Belum ada todo.</div>
@endif