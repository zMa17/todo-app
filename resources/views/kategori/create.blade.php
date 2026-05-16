<div>
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <div>
            <label for="nama">Nama Kategori:</label>
            <input type="text" name="nama" id="nama" required>
        </div>
        <div>
            <label for="warna">Warna Kategori:</label>
            <input type="color" name="warna" id="warna" value="#6366f1" required>
        </div>
        <div>
            <button type="submit">Tambah Kategori</button>
        </div>
    </form>
</div>
