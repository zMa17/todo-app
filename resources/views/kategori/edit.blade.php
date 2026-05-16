<div>
    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div>
            <label for="nama">Nama Kategori:</label>
            <input type="text" name="nama" id="nama" value="{{ $kategori->nama }}" required>
        </div>
        <div>
            <label for="warna">Warna Kategori:</label>
            <input type="color" name="warna" id="warna" value="{{ $kategori->warna }}" required>
        </div>
        <div>
            <button type="submit">Update Kategori</button>
        </div>
    </form>
</div>
