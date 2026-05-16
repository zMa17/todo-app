<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Todo</title>
</head>
<body>

<h1>Tambah Todo</h1>
<a href="{{ route('todo.index') }}">← Kembali</a>

<br><br>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('todo.store') }}" method="POST">
    @csrf

    <table cellpadding="8">
        <tr>
            <td>Judul</td>
            <td>
                <input type="text" name="judul" value="{{ old('judul') }}" required>
            </td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>
                <textarea name="deskripsi" required>{{ old('deskripsi') }}</textarea>
            </td>
        </tr>
        <tr>
            <td>Tanggal Deadline</td>
            <td>
                <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline') }}" required>
            </td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>
                <select name="kategori_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Prioritas</td>
            <td>
                <label>
                    <input type="radio" name="prioritas" value="low" {{ old('prioritas') == 'low' ? 'checked' : '' }} required> Low
                </label>
                <label>
                    <input type="radio" name="prioritas" value="medium" {{ old('prioritas') == 'medium' ? 'checked' : '' }} required> Medium
                </label>
                <label>
                    <input type="radio" name="prioritas" value="high" {{ old('prioritas') == 'high' ? 'checked' : '' }} required> High
                </label>
            </td>
        </tr>
        <tr>
            <td>Tags</td>
            <td>
                @foreach ($tags as $tag)
                    <label>
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                        {{ $tag->nama }}
                    </label><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <label>
                    <input type="checkbox" name="is_completed" value="1" {{ old('is_completed') ? 'checked' : '' }}>
                    Sudah Selesai
                </label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit">Simpan</button></td>
        </tr>
    </table>

</form>

</body>
</html>