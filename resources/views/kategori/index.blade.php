<div>
    <h1>Daftar Kategori</h1>
    <a href="{{ route('kategori.create') }}">Tambah Kategori</a>
    <table>
        <tr>
            <th>Nama</th>
            <th>Warna</th>
            <th>Aksi</th>
        </tr>
        @foreach($kategoris as $kategori)
            <tr>
                <td>{{ $kategori->nama }}</td>
                <td><span style="color: {{ $kategori->warna }};">{{ $kategori->warna }}</span></td>
                <td>
                    <a href="{{ route('kategori.edit', $kategori->id) }}">Edit</a>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>
