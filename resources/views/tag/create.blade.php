<div>
    <form action="{{ route('tag.store') }}" method="POST">
        @csrf
        <div>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required>
        </div>
        <div>
            <label for="warna">Warna:</label>
            <input type="color" name="warna" id="warna" value="#f59e0b" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
</div>

