<div>
    <form action="{{ route('tag.update', $tag->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" value="{{ $tag->nama }}" required>
        </div>
        <div>
            <label for="warna">Warna:</label>
            <input type="color" name="warna" id="warna" value="{{ $tag->warna }}" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
</div>

