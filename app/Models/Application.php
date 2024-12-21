<?php

namespace App\Models;

use App\Enums\PaymentEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone',
        'receipt_date',
        'user_id',
        'service_id',
        'service_inf',
        'payment_type',
        'status',
    ];

    public function getPaymentLabelAttribute(): string
    {
        return $this->payment_type->label();
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    protected function casts(): array
    {
        return [
            'receipt_date' => 'datetime',
            'user_id' => 'integer',
            'service_id' => 'integer',
            'payment_type' => PaymentEnum::class,
            'status' => StatusEnum::class,
        ];
    }
}
