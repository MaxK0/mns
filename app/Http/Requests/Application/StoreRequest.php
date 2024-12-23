<?php

namespace App\Http\Requests\Application;

use App\Enums\PaymentEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'receipt_date' => ['required', 'date'],
            'service_id' => ['nullable', 'integer', 'exists:App\Models\Service,id'],
            'service_info' => ['nullable', 'string'],
            'payment_type' => ['required', Rule::enum(PaymentEnum::class)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (empty($this->service_id) && empty($this->service_info)) {
                    $validator->errors()->add(
                        'service_id',
                        "Поле 'service' обязательно для заполнения"
                    );
                }
            }
        ];
    }
}
