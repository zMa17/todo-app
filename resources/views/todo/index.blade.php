<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Todo List</title>
</head>
<body>

<h1>Todo List</h1>
<a href="{{ route('todo.create') }}">+ Tambah Todo</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tags</th>
            <th>Deadline</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($todos as $todo)
        <tr>
            <td>{{ $todo->judul }}</td>
            <td><span style="color: {{ $todo->kategori->warna }}">{{ $todo->kategori->nama }}</span></td>
            <td>
                @foreach ($todo->tags as $tag)
                    <span style="color: {{ $tag->warna }}">{{ $tag->nama }}</span>@if (!$loop->last), @endif
                @endforeach
            </td>
            <td>{{ $todo->tanggal_deadline->format('d M Y') }}</td>
            <td>{{ $todo->prioritas }}</td>
            <td>{{ $todo->is_completed ? 'Selesai' : 'Belum Selesai' }}</td>
            <td>
                <a href="{{ route('todo.edit', $todo) }}">Edit</a>

                <form action="{{ route('todo.destroy', $todo) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin ingin menghapus todo ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Belum ada todo.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>