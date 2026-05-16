<div>
    <h1>Daftar Tag</h1>
    <a href="{{ route('tag.create') }}">Tambah Tag</a>
    <ul>
        @foreach ($tags as $tag)
            <li>
                <span style="color: {{ $tag->warna }};">{{ $tag->nama }}</span>
                <a href="{{ route('tag.edit', $tag->id) }}">Edit</a>
                <form action="{{ route('tag.destroy', $tag->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus tag ini?')">Hapus</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
