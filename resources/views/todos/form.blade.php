@php
    $todo ??= null;
    $isEdit = $todo !== null;
@endphp

<div class="space-y-6">
    {{-- 1 & 2. TextField: Judul & Deskripsi --}}
    <div>
        <label class="block text-sm mb-1 text-[#706f6c] dark:text-[#A1A09A]">Judul <span class="text-[#ef4444]">*</span></label>
        <input type="text" name="title" value="{{ old('title', $todo->title ?? '') }}"
               class="w-full px-4 py-2 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]"
               placeholder="Masukkan judul todo">
        @error('title')
            <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm mb-1 text-[#706f6c] dark:text-[#A1A09A]">Deskripsi</label>
        <textarea name="description" rows="3"
                  class="w-full px-4 py-2 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]"
                  placeholder="Masukkan deskripsi (opsional)">{{ old('description', $todo->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p>
        @enderror
    </div>

    {{-- 3. Dropdown: Kategori --}}
    <div>
        <label class="block text-sm mb-1 text-[#706f6c] dark:text-[#A1A09A]">Kategori <span class="text-[#ef4444]">*</span></label>
        <select name="category_id"
                class="w-full px-4 py-2 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $todo->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p>
        @enderror
    </div>

    {{-- 4. RadioButton: Prioritas --}}
    <div>
        <label class="block text-sm mb-2 text-[#706f6c] dark:text-[#A1A09A]">Prioritas <span class="text-[#ef4444]">*</span></label>
        <div class="flex gap-6">
            @foreach(['low' => 'Low 🟢', 'medium' => 'Medium 🟡', 'high' => 'High 🔴'] as $value => $label)
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="radio" name="priority" value="{{ $value }}"
                           class="accent-[#f53003] dark:accent-[#FF4433]"
                           {{ old('priority', $todo->priority ?? 'medium') == $value ? 'checked' : '' }}>
                    {{ $label }}
                </label>
            @endforeach
        </div>
        @error('priority')
            <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p>
        @enderror
    </div>

    {{-- 5. CheckBox: Tags --}}
    <div>
        <label class="block text-sm mb-2 text-[#706f6c] dark:text-[#A1A09A]">Tags</label>
        <div class="flex flex-wrap gap-4">
            @foreach($tags as $tag)
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                           class="accent-[#f53003] dark:accent-[#FF4433]"
                           {{ in_array($tag->id, old('tags', $todo?->tags->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                    {{ $tag->name }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- 6. Switch/Toggle: Selesai --}}
    <div>
        <label class="flex items-center gap-3 text-sm cursor-pointer">
            <div class="relative">
                <input type="hidden" name="is_completed" value="0">
                <input type="checkbox" name="is_completed" value="1" role="switch"
                       class="peer sr-only"
                       {{ old('is_completed', $todo->is_completed ?? false) ? 'checked' : '' }}>
                <div class="w-10 h-5 rounded-full border border-[#19140035] dark:border-[#3E3E3A] bg-transparent peer-checked:bg-[#10b981] peer-checked:border-[#10b981] transition-colors"></div>
                <div class="absolute top-0.5 left-0.5 w-4 h-4 rounded-full bg-[#706f6c] dark:bg-[#A1A09A] peer-checked:bg-white peer-checked:translate-x-5 transition-all"></div>
            </div>
            <span class="text-[#706f6c] dark:text-[#A1A09A]">Tandai selesai</span>
        </label>
    </div>

    {{-- 7. Date: Deadline --}}
    <div>
        <label class="block text-sm mb-1 text-[#706f6c] dark:text-[#A1A09A]">Deadline <span class="text-[#ef4444]">*</span></label>
        <input type="date" name="due_date" value="{{ old('due_date', $todo?->due_date?->format('Y-m-d') ?? '') }}"
               class="w-full px-4 py-2 text-sm bg-transparent border border-[#19140035] dark:border-[#3E3E3A] rounded-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]">
        @error('due_date')
            <p class="mt-1 text-sm text-[#ef4444]">{{ $message }}</p>
        @enderror
    </div>
</div>
