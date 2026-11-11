<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a migração.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('fabricante');
            $table->integer('quantidade');
            $table->decimal('preco', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverte a migração.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
