<?php

namespace App\Http\Requests\Admin\Application;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'integer', Rule::enum(StatusEnum::class)],
            'reason_for_cancel' => [
                $this->status == StatusEnum::Cancelled->value ? 'required' : 'nullable',
                'string'
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
