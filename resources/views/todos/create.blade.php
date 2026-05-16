@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-medium mb-8">Buat Todo Baru</h1>

        <form action="{{ route('todos.store') }}" method="POST"
              class="p-6 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-sm">
            @csrf
            @include('todos.form', ['todo' => null])

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-[#19140035] dark:border-[#3E3E3A]">
                <button type="submit"
                        class="px-5 py-1.5 dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] bg-[#1b1b18] border border-black text-white text-sm leading-normal rounded-sm hover:bg-black">
                    Simpan
                </button>
                <a href="{{ route('todos.index') }}"
                   class="px-5 py-1.5 text-sm border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:bg-[#1914000a] dark:hover:bg-[#fffaed0a]">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
