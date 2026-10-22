<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// статьи (новости)
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->string('heading', 200);
            $table->text('text');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');   // автор статьи
            $table->timestamps();

            // внешние ключи, удаление справочника запрещено (restrict)
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');

            // индексы под выборку по категории и сортировку на главной
            $table->index('category_id');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('texts');
    }
};
