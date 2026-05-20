<x-app-layout>
    <div class="flex h-[calc(100vh-0px)]">
        <div class="flex-1 overflow-y-auto px-8 py-8">
            <div class="flex items-center mb-6">
                <h1 style="font-size:32px;font-weight:700" class="flex-1">Upcoming</h1>
                <span class="px-2 py-0.5 bg-gray-100 text-gray-400">{{ $todos->count() }}</span>
            </div>
            @foreach ($todos as $todo)
                <div class="flex px-4 py-3 border-b">
                    <div class="mr-3">
                        <div class="w-5 h-5 border-2 {{ $todo->is_completed ? 'bg-amber-400 border-amber-400' : 'border-gray-300' }}" style="display:flex;align-items:center;justify-content:center">
                            @if ($todo->is_completed) &#10003; @endif
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="{{ $todo->is_completed ? 'text-gray-400' : '' }}" style="{{ $todo->is_completed ? 'text-decoration:line-through' : '' }}">{{ $todo->judul }}</div>
                    </div>
                    <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300" style="text-decoration:none">></a>
                </div>
            @endforeach
        </div>

        <aside class="w-80 border-l bg-white flex flex-col">
            <div class="flex items-center px-5 py-4 border-b">
                <span class="flex-1">Tambah Todo</span>
                <a href="{{ route('todo.index') }}" class="text-gray-400" style="text-decoration:none">&times;</a>
            </div>
            <form action="{{ route('todo.store') }}" method="POST" class="flex flex-col flex-1">
                @csrf
                <div class="flex-1 px-5 py-4">
                    <div class="mb-4">
                        <input type="text" name="judul" placeholder="Judul task" value="{{ old('judul') }}" class="w-full px-3 py-2 border" required>
                        @error('judul') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full px-3 py-2 border" rows="3">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 flex items-center">
                        <span class="w-24 text-gray-500">Kategori</span>
                        <select name="kategori_id" class="flex-1 px-3 py-1.5 border">
                            <option value="">-- Pilih --</option>
                            @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 flex items-center">
                        <span class="w-24 text-gray-500">Deadline</span>
                        <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline') }}" class="flex-1 px-3 py-1.5 border" required>
                        @error('tanggal_deadline') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <span class="text-gray-500">Tags</span>
                        <div class="mt-1">
                            @foreach ($tags as $tag)
                                <label class="inline-block mr-2 px-3 py-1 mb-1" style="background:{{ $tag->warna }}20;color:{{ $tag->warna }}">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                    {{ $tag->nama }}
                                </label>
                            @endforeach
                        </div>
                        @error('tags') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <span class="text-gray-500">Prioritas</span>
                        <div class="flex mt-1">
                            @foreach (['low'=>'Low','medium'=>'Medium','high'=>'High'] as $val=>$label)
                                <label class="mr-3 px-3 py-1 {{ old('prioritas') == $val ? 'bg-amber-400 text-white' : 'bg-gray-100' }}">
                                    <input type="radio" name="prioritas" value="{{ $val }}" {{ old('prioritas') == $val ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        @error('prioritas') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 mr-3">Completed</span>
                        <label class="relative">
                            <input type="checkbox" name="is_completed" value="1" {{ old('is_completed') ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-gray-200 rounded-full peer-checked:bg-amber-400" style="transition:0.2s">
                                <div class="w-4 h-4 bg-white rounded-full" style="transition:0.2s;transform:{{ old('is_completed') ? 'translateX(16px)' : 'translateX(2px)' }};margin-top:2px"></div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="px-5 py-4 border-t">
                    <button type="submit" class="w-full py-2 bg-amber-400 text-white" style="border:none">Simpan</button>
                </div>
            </form>
        </aside>
    </div>
</x-app-layout>