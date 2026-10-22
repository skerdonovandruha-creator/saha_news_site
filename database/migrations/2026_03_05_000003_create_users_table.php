<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// пользователи сайта: логин, хеш пароля и ссылка на роль
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->string('login', 50)->unique();   // логин уникальный
            $table->string('password');               // здесь лежит bcrypt-хеш
            $table->timestamps();

            // внешний ключ: нельзя удалить роль, пока есть такие пользователи
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');

            $table->index('role_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
