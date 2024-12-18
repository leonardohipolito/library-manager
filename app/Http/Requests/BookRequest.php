<?php

namespace App\Http\Requests;

use App\Enums\BookStatus;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $book = $this->route('book');
        if (! $book) {
            return $this->user()->can('create', Book::class);
        }

        return $this->user()->can('update', $book);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'status' => ['required', Rule::in(BookStatus::options()->keys()->toArray())],
        ];
    }
}
