<?php

namespace App\Http\Requests;

use App\Enums\BookStatus;
use App\Enums\LoanStatus;
use App\Models\Loan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $loan = $this->route('loan');
        if (! $loan) {
            return $this->user()->can('create', Loan::class);
        }

        return $this->user()->can('update', $loan);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                Rule::exists('books', 'id')->when($this->isMethod('POST'))->where('status', BookStatus::available),
            ],
            'borrower_id' => ['required', Rule::exists('users', 'id')],
            'expires_at' => ['required', 'date'],
            'returned_at' => ['nullable', 'date'],
            'status' => [
                Rule::requiredIf($this->isMethod('PUT')),
                Rule::in(LoanStatus::options()->keys()->toArray()),
            ],
        ];
    }
}
