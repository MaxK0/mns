<?php

use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->string('address');
            $table->string('phone', 10);
            $table->dateTime('receipt_date');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('service_inf')
                ->nullable();

            $table->unsignedTinyInteger('payment_type');
            $table->unsignedTinyInteger('status')
                ->default(StatusEnum::New);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
