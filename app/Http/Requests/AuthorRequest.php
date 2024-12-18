<?php

namespace App\Http\Requests;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $author = $this->route('author');
        if (! $author) {
            return $this->user()->can('create', Author::class);
        }

        return $this->user()->can('update', $author);
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
        ];
    }
}
