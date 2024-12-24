<?php

namespace App\Http\Requests\Application;

use App\Enums\PaymentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone' => ['required', 'string', 'max:10'],
            'receipt_date' => ['required', 'date', 'after:now'],
            'is_another_service' => ['required', 'boolean'],
            'service_id' => [
                $this->is_another_service ? 'nullable' : 'required',
                'integer', 'exists:App\Models\Service,id'
            ],
            'service_inf' => [
                $this->is_another_service ? 'required' : 'nullable',
                'string'
            ],
            'payment_type' => ['required', Rule::enum(PaymentEnum::class)],
        ];
    }

    public function prepareForValidation()
    {
        $phone = $this->phone;

        if (!empty($phone)) {
            $phone = preg_replace("/[^0-9]/", "", $phone);
            $phone = substr($phone, 1);
        }

        $this->merge([
            'service_id' => $this->service['id'] ?? null,
            'payment_type' => $this->payment_type['id'] ?? null,
            'phone' => $phone,
        ]);
    }
}
