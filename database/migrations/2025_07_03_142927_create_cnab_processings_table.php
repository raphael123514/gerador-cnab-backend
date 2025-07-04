<?php

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
        Schema::create('cnab_processings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('fund_id')->constrained('funds');

            $table->string('original_filename'); // Nome do arquivo importado
            $table->string('original_filepath'); // Caminho para baixar o Excel
            $table->string('cnab_filepath')->nullable(); // Caminho para baixar o CNAB
            $table->string('file_sequence'); // "Sequência do Arquivo"
            $table->enum('status', ['pendente', 'processando', 'concluido', 'erro'])->default('pendente');
            $table->timestamps(); // created_at será a Data da solicitação
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnab_processings');
    }
};
