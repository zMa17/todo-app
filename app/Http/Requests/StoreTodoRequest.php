<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'is_completed' => 'nullable|boolean',
            'due_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul belum diisi',
            'category_id.required' => 'Kategori belum dipilih',
            'priority.required' => 'Prioritas belum dipilih',
            'due_date.required' => 'Tanggal deadline belum diisi',
            'due_date.date' => 'Format tanggal tidak valid',
        ];
    }
}
