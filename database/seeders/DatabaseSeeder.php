<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\Text;
use App\Models\User;
use Illuminate\Database\Seeder;

// Заливает справочники, тестовых пользователей и статьи
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ====== 1. Роли ======
        $roleUser = Role::create(['name' => 'user']);
        $roleJournalist = Role::create(['name' => 'journalist']);
        $roleAdmin = Role::create(['name' => 'admin']);

        // ====== 2. Категории ======
        $catTech = Category::create(['name' => 'Технологии']);
        $catSpace = Category::create(['name' => 'Космос']);

        // ====== 3. Тестовые пользователи ======
        User::create([
            'role_id' => $roleAdmin->id,
            'login' => 'admin',
            'password' => '123456',
        ]);

        User::create([
            'role_id' => $roleJournalist->id,
            'login' => 'korrespondent',
            'password' => '123456',
        ]);

        User::create([
            'role_id' => $roleUser->id,
            'login' => 'chitatel',
            'password' => '123456',
        ]);

        // ====== 4. Статьи ======
        $journalist = User::where('login', 'korrespondent')->first();

        Text::create([
            'heading' => 'Нейросети научились писать код лучше программистов',
            'text' => 'Новые модели искусственного интеллекта способны не только генерировать, но и отлаживать программный код. Исследователи из MIT провели серию экспериментов, показавших, что ИИ справляется с задачами сложнее, чем средний junior-разработчик.',
            'category_id' => $catTech->id,
            'user_id' => $journalist->id,
        ]);

        Text::create([
            'heading' => 'Tesla представила новый электромобиль с пробегом 1000 км',
            'text' => 'Автомобиль оснащён батареей нового поколения, которая заряжается за 15 минут. Ожидается, что цена на машину будет конкурентной, что может существенно изменить рынок электротранспорта.',
            'category_id' => $catTech->id,
            'user_id' => $journalist->id,
        ]);

        Text::create([
            'heading' => 'Космический телескоп обнаружил воду на экзопланете',
            'text' => 'На планете Kepler-186f, находящейся в обитаемой зоне, телескоп «Джеймс Уэбб» зафиксировал спектральные признаки водяного пара. Это может указывать на возможность существования жизни.',
            'category_id' => $catSpace->id,
            'user_id' => $journalist->id,
        ]);

        Text::create([
            'heading' => 'Квантовый интернет: первые шаги',
            'text' => 'Голландские учёные успешно передали квантовое состояние на расстояние 100 км. Это делает возможным создание сети, которая будет практически невозможно взломать.',
            'category_id' => $catTech->id,
            'user_id' => $journalist->id,
        ]);

        Text::create([
            'heading' => 'NASA объявило о планах миссии на Марс',
            'text' => 'Агентство подтвердило, что пилотируемая миссия на Марс запланирована на 2030 год. В рамках проекта будет построен новый ракетный комплекс и космическая станция на орбите.',
            'category_id' => $catSpace->id,
            'user_id' => $journalist->id,
        ]);
    }
}
