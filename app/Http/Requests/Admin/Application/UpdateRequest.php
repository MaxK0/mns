<?php

namespace App\Http\Requests\Admin\Application;

use App\Enums\PaymentEnum;
use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
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
            'status' => ['required', Rule::enum(StatusEnum::class)],
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

    public function prepareForValidation(): void
    {
        $phone = $this->phone;

        if (!empty($phone)) {
            $phone = preg_replace("/[^0-9]/", "", $phone);
            $phone = substr($phone, 1);
        }

        $this->merge([
            'service_id' => $this->service['id'] ?? null,
            'payment_type' => $this->payment_type['id'] ?? null,
            'status' => $this->status['id'] ?? null,
            'phone' => $phone,
        ]);
    }
}
