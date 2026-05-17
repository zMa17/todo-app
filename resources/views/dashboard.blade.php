<x-app-layout>
    <div class="flex" x-data="{ filterOpen: false }">
        {{-- Sidebar --}}
        <aside class="w-64 bg-[#f6f5f4] border-r border-[#e5e3df] min-h-[calc(100vh-4rem)] p-5 shrink-0 hidden md:block">
            <div class="space-y-6">
                {{-- Navigation --}}
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-[#37352f] rounded-lg hover:bg-[#ede9e4] {{ request()->routeIs('dashboard') && !request()->anyFilled(['kategori_id', 'tag_id']) ? 'bg-[#e5e3df] font-medium' : '' }}">
                        <span>Semua Todo</span>
                        <span class="ml-auto text-xs text-[#787671]">{{ $todos->count() }}</span>
                    </a>
                    <a href="{{ route('kategori.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-[#37352f] rounded-lg hover:bg-[#ede9e4]">
                        <span>Kelola Kategori</span>
                    </a>
                    <a href="{{ route('tag.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-[#37352f] rounded-lg hover:bg-[#ede9e4]">
                        <span>Kelola Tag</span>
                    </a>
                </div>

                <hr class="border-[#e5e3df]">

                {{-- Kategori Filter --}}
                <div>
                    <h3 class="text-xs font-semibold text-[#787671] uppercase tracking-wide mb-2 px-3">Kategori</h3>
                    <div class="space-y-1">
                        @foreach ($kategoris as $k)
                            <a href="{{ request()->fullUrlWithQuery(['kategori_id' => $k->id, 'tag_id' => null]) }}"
                               class="flex items-center gap-2 px-3 py-1.5 rounded-full text-sm {{ request('kategori_id') == $k->id ? 'bg-[#e5e3df] font-medium text-[#1a1a1a]' : 'text-[#37352f] hover:bg-[#ede9e4]' }}">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $k->warna }}"></span>
                                {{ $k->nama }}
                                <span class="ml-auto text-xs text-[#787671]">{{ $k->todos_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <hr class="border-[#e5e3df]">

                {{-- Tag Filter --}}
                <div>
                    <h3 class="text-xs font-semibold text-[#787671] uppercase tracking-wide mb-2 px-3">Tag</h3>
                    <div class="flex flex-wrap gap-1.5 px-3">
                        @foreach ($tags as $t)
                            <a href="{{ request()->fullUrlWithQuery(['tag_id' => $t->id, 'kategori_id' => null]) }}"
                               class="inline-block px-2.5 py-1 rounded text-xs font-medium {{ request('tag_id') == $t->id ? 'bg-[#c8c4be] text-white' : 'bg-[#e6e0f5] text-[#391c57] hover:bg-[#d6b6f6]' }}">
                                {{ $t->nama }} ({{ $t->todos_count }})
                            </a>
                        @endforeach
                    </div>
                </div>

                <hr class="border-[#e5e3df]">

                {{-- Advanced Filter Button --}}
                <div class="px-3">
                    <button @click="filterOpen = true" class="w-full px-4 py-2 text-sm text-[#37352f] border border-[#c8c4be] rounded-lg hover:bg-[#ede9e4] text-left">
                        Filter Lanjutan
                    </button>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-[#d9f3e1] text-[#1aae39] rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Inline Add Todo Form --}}
            <div class="bg-white border border-[#e5e3df] rounded-xl p-5 mb-6">
                <h2 class="text-lg font-semibold text-[#1a1a1a] mb-4">Tambah Todo Baru</h2>

                @if ($errors->any())
                    <div class="mb-4 px-4 py-3 bg-[#fde0ec] text-[#e03131] rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('todo.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Judul</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm focus:outline-none focus:ring-2 focus:ring-[#5645d4] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Kategori</label>
                            <select name="kategori_id" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm focus:outline-none focus:ring-2 focus:ring-[#5645d4] focus:border-transparent">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="2" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#5645d4] focus:border-transparent">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Prioritas</label>
                            <div class="flex gap-4 pt-1">
                                <label class="flex items-center gap-1.5 text-sm text-[#37352f]">
                                    <input type="radio" name="prioritas" value="low" {{ old('prioritas') == 'low' ? 'checked' : '' }} required>
                                    Low
                                </label>
                                <label class="flex items-center gap-1.5 text-sm text-[#37352f]">
                                    <input type="radio" name="prioritas" value="medium" {{ old('prioritas') == 'medium' ? 'checked' : '' }}>
                                    Medium
                                </label>
                                <label class="flex items-center gap-1.5 text-sm text-[#37352f]">
                                    <input type="radio" name="prioritas" value="high" {{ old('prioritas') == 'high' ? 'checked' : '' }}>
                                    High
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Tanggal Deadline</label>
                            <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline') }}" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm focus:outline-none focus:ring-2 focus:ring-[#5645d4] focus:border-transparent">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-2">Tags</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tags as $t)
                                    <label class="flex items-center gap-1.5 text-sm text-[#37352f]">
                                        <input type="checkbox" name="tags[]" value="{{ $t->id }}"
                                            {{ in_array($t->id, old('tags', [])) ? 'checked' : '' }}>
                                        {{ $t->nama }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-end">
                            <label class="flex items-center gap-2 text-sm text-[#37352f]">
                                <input type="checkbox" name="is_completed" value="1" {{ old('is_completed') ? 'checked' : '' }}>
                                Sudah Selesai
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-5 py-2.5 bg-[#5645d4] hover:bg-[#4534b3] text-white rounded-lg text-sm font-medium">
                            Simpan Todo
                        </button>
                    </div>
                </form>
            </div>

            {{-- Active Filters Info --}}
            @if(request()->anyFilled(['kategori_id', 'tag_id', 'search', 'prioritas', 'deadline_from', 'deadline_to']) || request()->has('is_completed'))
                <div class="mb-4 flex items-center gap-2 flex-wrap">
                    <span class="text-xs text-[#787671] font-medium">Filter aktif:</span>
                    @if(request('kategori_id'))
                        @php $k = $kategoris->firstWhere('id', request('kategori_id')); @endphp
                        @if($k)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-[#e5e3df] rounded-full text-xs">
                                Kategori: {{ $k->nama }}
                                <a href="{{ request()->fullUrlWithQuery(['kategori_id' => null]) }}" class="text-[#787671] hover:text-[#1a1a1a]">&times;</a>
                            </span>
                        @endif
                    @endif
                    @if(request('tag_id'))
                        @php $t = $tags->firstWhere('id', request('tag_id')); @endphp
                        @if($t)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-[#e6e0f5] rounded-full text-xs">
                                Tag: {{ $t->nama }}
                                <a href="{{ request()->fullUrlWithQuery(['tag_id' => null]) }}" class="text-[#787671] hover:text-[#1a1a1a]">&times;</a>
                            </span>
                        @endif
                    @endif
                    <a href="{{ route('dashboard') }}" class="text-xs text-[#5645d4] hover:underline">Hapus semua filter</a>
                </div>
            @endif

            {{-- Todo Cards Grid --}}
            @if ($todos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($todos as $todo)
                        <div class="bg-white border border-[#e5e3df] rounded-xl p-5 hover:shadow-sm transition-shadow">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    @if ($todo->prioritas == 'high')
                                        <span class="w-2 h-2 rounded-full bg-[#dd5b00]"></span>
                                    @elseif ($todo->prioritas == 'medium')
                                        <span class="w-2 h-2 rounded-full bg-[#f5d75e]"></span>
                                    @else
                                        <span class="w-2 h-2 rounded-full bg-[#787671]"></span>
                                    @endif
                                    <h3 class="font-semibold text-[#1a1a1a] {{ $todo->is_completed ? 'line-through text-[#bbb8b1]' : '' }}">
                                        {{ $todo->judul }}
                                    </h3>
                                </div>
                                <form action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus todo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[#bbb8b1] hover:text-[#e03131] text-sm">&times;</button>
                                </form>
                            </div>

                            <p class="text-sm text-[#787671] mb-3 line-clamp-2">{{ $todo->deskripsi }}</p>

                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                <span class="px-2 py-0.5 rounded text-xs font-medium" style="background-color: {{ $todo->kategori->warna }}20; color: {{ $todo->kategori->warna }}">
                                    {{ $todo->kategori->nama }}
                                </span>
                                @foreach ($todo->tags as $tag)
                                    <span class="px-2 py-0.5 bg-[#e6e0f5] text-[#391c57] rounded text-xs font-medium">
                                        {{ $tag->nama }}
                                    </span>
                                @endforeach
                            </div>

                            <div class="flex items-center justify-between text-xs text-[#787671]">
                                <span>{{ $todo->tanggal_deadline->format('d M Y') }}</span>
                                <div class="flex items-center gap-2">
                                    @if ($todo->is_completed)
                                        <span class="text-[#1aae39] font-medium">Selesai</span>
                                    @else
                                        <span class="text-[#dd5b00]">Belum Selesai</span>
                                    @endif
                                    <a href="{{ route('todo.edit', $todo->id) }}" class="text-[#5645d4] hover:underline">Edit</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-[#787671]">Belum ada todo.</p>
                    <p class="text-sm text-[#bbb8b1] mt-1">Buat todo baru menggunakan form di atas.</p>
                </div>
            @endif
        </main>
    </div>

    {{-- Advanced Filter Modal --}}
    {{-- <div x-show="filterOpen" class="fixed inset-0 bg-black/50 z-50 flex items-start justify-center pt-20"
         x-cloak @click.away="filterOpen = false">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg mx-4 shadow-xl" @click.stop>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-[#1a1a1a]">Filter Lanjutan</h3>
                <button @click="filterOpen = false" class="text-[#787671] hover:text-[#1a1a1a]">&times;</button>
            </div>

            <form method="GET" action="{{ route('dashboard') }}">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi..."
                            class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Kategori</label>
                        <select name="kategori_id"
                            class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Tag</label>
                        <select name="tag_id"
                            class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                            <option value="">Semua Tag</option>
                            @foreach ($tags as $t)
                                <option value="{{ $t->id }}" {{ request('tag_id') == $t->id ? 'selected' : '' }}>{{ $t->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Prioritas</label>
                        <select name="prioritas"
                            class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                            <option value="">Semua Prioritas</option>
                            <option value="low" {{ request('prioritas') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('prioritas') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('prioritas') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#37352f] mb-1">Status</label>
                        <select name="is_completed"
                            class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                            <option value="">Semua Status</option>
                            <option value="0" {{ request('is_completed') == '0' ? 'selected' : '' }}>Belum Selesai</option>
                            <option value="1" {{ request('is_completed') == '1' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Deadline Dari</label>
                            <input type="date" name="deadline_from" value="{{ request('deadline_from') }}"
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Deadline Sampai</label>
                            <input type="date" name="deadline_to" value="{{ request('deadline_to') }}"
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6">
                    <button type="submit" class="px-5 py-2.5 bg-[#5645d4] hover:bg-[#4534b3] text-white rounded-lg text-sm font-medium">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm text-[#37352f] border border-[#c8c4be] rounded-lg hover:bg-[#f6f5f4]">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div> --}}
</x-app-layout>
