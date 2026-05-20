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
            <h1 style="font-size:32px;font-weight:700" class="flex-1" id="page-title">{{ $title }}</h1>
            <span class="px-2 py-0.5 bg-gray-100 rounded-lg text-gray-400" id="todo-count">{{ $todos->count() }}</span>
        </div>

        <a href="{{ route('todo.create') }}" class="flex px-4 py-3 border rounded-lg mb-6 text-gray-400" style="text-decoration:none">+ Add New Task</a>

        <div id="todo-list">
            @include('todo._list')
        </div>
    </div>

    <script>
        window.loadTodos = function(url) {
            const separator = url.includes('?') ? '&' : '?';
            fetch(url + separator + '_ajax=1', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('todo-list').innerHTML = data.html;
                const countEl = document.getElementById('todo-count');
                if (countEl) countEl.textContent = data.count;
                history.pushState({}, '', url);
            });
        };
    </script>
</x-app-layout>