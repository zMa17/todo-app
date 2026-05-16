<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Todo</title>
</head>
<body>

<h1>Edit Todo</h1>
<a href="{{ route('todo.index') }}">← Kembali</a>

<br><br>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('todo.update', $todo) }}" method="POST">
    @csrf
    @method('PUT')

    <table cellpadding="8">
        <tr>
            <td>Judul</td>
            <td>
                <input type="text" name="judul" value="{{ old('judul', $todo->judul) }}">
            </td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>
                <textarea name="deskripsi">{{ old('deskripsi', $todo->deskripsi) }}</textarea>
            </td>
        </tr>
        <tr>
            <td>Tanggal Deadline</td>
            <td>
                <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline', $todo->tanggal_deadline->format('Y-m-d')) }}">
            </td>
        </tr>
        <tr>
            <td>Kategori</td>
            <td>
                <select name="kategori_id">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $todo->kategori_id) == $kategori->id ? 'selected' : '' }}>
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
                    <input type="radio" name="prioritas" value="low"
                        {{ old('prioritas', $todo->prioritas) == 'low' ? 'checked' : '' }}> Low
                </label>
                <label>
                    <input type="radio" name="prioritas" value="medium"
                        {{ old('prioritas', $todo->prioritas) == 'medium' ? 'checked' : '' }}> Medium
                </label>
                <label>
                    <input type="radio" name="prioritas" value="high"
                        {{ old('prioritas', $todo->prioritas) == 'high' ? 'checked' : '' }}> High
                </label>
            </td>
        </tr>
        <tr>
            <td>Tags</td>
            <td>
                @php
                    $selectedTags = old('tags', $todo->tags->pluck('id')->toArray());
                @endphp
                @foreach ($tags as $tag)
                    <label>
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                        {{ $tag->nama }}
                    </label><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <label>
                    <input type="checkbox" name="is_completed" value="1"
                        {{ old('is_completed', $todo->is_completed) ? 'checked' : '' }}>
                    Sudah Selesai
                </label>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit">Update</button></td>
        </tr>
    </table>

</form>

</body>
</html>