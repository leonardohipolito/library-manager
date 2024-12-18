<?php

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'attendant_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'borrower_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->date('expires_at');
            $table->date('returned_at')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
