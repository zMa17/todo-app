<x-app-layout>
    <div class="flex h-[calc(100vh-0px)]">
        <div class="flex-1 overflow-y-auto">
            <div class="px-8 py-8">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-4xl font-bold text-gray-900">Todo Lists</h1>
                    <span class="text-sm text-gray-400 bg-gray-100 px-2.5 py-0.5 rounded-full">{{ $todos->count() }}</span>
                </div>

                <div class="space-y-0">
                    @forelse ($todos as $todo)
                        <div class="group flex items-start gap-3 px-4 py-3 border-b border-[#e5e5e4] hover:bg-gray-50 transition-colors rounded-lg -mx-4">
                            <div class="pt-0.5">
                                <div class="w-5 h-5 rounded border-2 {{ $todo->is_completed ? 'bg-amber-400 border-amber-400' : 'border-gray-300' }} flex items-center justify-center">
                                    @if ($todo->is_completed)
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm {{ $todo->is_completed ? 'line-through text-gray-400' : 'font-medium text-gray-900' }}">
                                    {{ $todo->judul }}
                                </p>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    @if ($todo->tanggal_deadline)
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $todo->tanggal_deadline->format('M d') }}
                                        </span>
                                    @endif

                                    @if ($todo->kategori)
                                        <span class="inline-flex items-center gap-1 text-xs text-gray-500">
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $todo->kategori->warna }}"></span>
                                            {{ $todo->kategori->nama }}
                                        </span>
                                    @endif

                                    @foreach ($todo->tags as $tag)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $tag->warna }}20; color: {{ $tag->warna }}">
                                            {{ $tag->nama }}
                                        </span>
                                    @endforeach

                                    @if ($todo->prioritas === 'high')
                                        <span class="inline-flex items-center gap-1 text-xs text-red-500">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            </svg>
                                            High
                                        </span>
                                    @elseif ($todo->prioritas === 'medium')
                                        <span class="inline-flex items-center gap-1 text-xs text-amber-500">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                                            </svg>
                                            Medium
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('todo.edit', $todo) }}" class="text-gray-300 hover:text-gray-500 transition-colors pt-1 opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <svg class="w-12 h-12 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-400 text-sm">Belum ada todo.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="w-80 border-l border-[#e5e5e4] bg-white flex flex-col h-full overflow-y-auto">
            <div class="flex items-center justify-between px-5 py-4 border-b border-[#e5e5e4]">
                <h2 class="text-sm font-semibold text-gray-800">Tambah Todo</h2>
                <a href="{{ route('todo.index') }}" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>

            <form action="{{ route('todo.store') }}" method="POST" class="flex flex-col flex-1">
                @csrf

                <div class="flex-1 px-5 py-4 space-y-6 overflow-y-auto">
                    <div>
                        <input type="text" name="judul" placeholder="Judul task"
                            value="{{ old('judul') }}"
                            class="w-full text-xl font-semibold text-gray-900 placeholder-gray-300 border-0 p-0 focus:ring-0 focus:outline-none"
                            required>
                        @error('judul')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <textarea name="deskripsi" placeholder="Deskripsi (opsional)"
                            class="w-full text-sm text-gray-600 placeholder-gray-300 border-0 p-0 focus:ring-0 focus:outline-none resize-none" rows="3" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</span>
                            <select name="kategori_id"
                                class="text-sm text-gray-700 border border-[#e5e5e4] rounded-lg px-3 py-1.5 focus:ring-1 focus:ring-amber-400 focus:border-amber-400 w-44" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kategori_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</span>
                            <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline') }}"
                                class="text-sm text-gray-700 border border-[#e5e5e4] rounded-lg px-3 py-1.5 focus:ring-1 focus:ring-amber-400 focus:border-amber-400 w-44"
                                required>
                        </div>
                        @error('tanggal_deadline')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <div>
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block mb-2">Tags</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tags as $tag)
                                    <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium cursor-pointer transition-colors"
                                        style="background-color: {{ old('tags') && in_array($tag->id, old('tags')) ? $tag->warna . '30' : $tag->warna . '10' }}; color: {{ $tag->warna }}; border: 1px solid {{ old('tags') && in_array($tag->id, old('tags')) ? $tag->warna . '40' : 'transparent' }}"
                                        onclick="this.querySelector('input').checked = !this.querySelector('input').checked; this.style.backgroundColor = this.querySelector('input').checked ? '{{ $tag->warna }}30' : '{{ $tag->warna }}10'; this.style.borderColor = this.querySelector('input').checked ? '{{ $tag->warna }}40' : 'transparent'">
                                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                                            class="hidden">
                                        {{ $tag->nama }}
                                    </label>
                                @endforeach
                            </div>
                            @error('tags')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block mb-2">Prioritas</span>
                            <div class="flex gap-2">
                                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $val => $label)
                                    <label class="flex-1 text-center px-3 py-1.5 rounded-lg text-xs font-medium cursor-pointer transition-colors
                                        {{ old('prioritas') == $val ? 'bg-amber-400 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                        <input type="radio" name="prioritas" value="{{ $val }}"
                                            {{ old('prioritas') == $val ? 'checked' : '' }}
                                            class="hidden"
                                            onchange="document.querySelectorAll('input[name=prioritas]').forEach(r => r.parentElement.classList.remove('bg-amber-400', 'text-white')); this.parentElement.classList.add('bg-amber-400', 'text-white'); this.parentElement.classList.remove('bg-gray-100', 'text-gray-500', 'hover:bg-gray-200')">
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                            @error('prioritas')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_completed" value="1" {{ old('is_completed') ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-amber-400 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="px-5 py-4 border-t border-[#e5e5e4]">
                    <button type="submit" class="w-full bg-amber-400 hover:bg-amber-500 text-white font-bold py-2.5 rounded-lg transition-colors text-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </aside>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('input[name="tags[]"]').forEach(input => {
                input.addEventListener('change', function() {
                    const label = this.closest('label');
                    const color = label.style.color;
                    if (this.checked) {
                        label.style.backgroundColor = color + '30';
                        label.style.borderColor = color + '40';
                    } else {
                        label.style.backgroundColor = color + '10';
                        label.style.borderColor = 'transparent';
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>