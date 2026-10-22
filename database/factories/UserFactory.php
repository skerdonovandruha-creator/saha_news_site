<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * По умолчанию — обычный читатель.
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::where('name', 'user')->value('id'),
            'login' => fake()->unique()->userName(),
            'password' => '123456',   // захешится через cast в модели
        ];
    }

    /**
     * Пользователь с ролью журналист.
     */
    public function journalist(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'journalist')->value('id'),
        ]);
    }

    /**
     * Пользователь с ролью админ.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => Role::where('name', 'admin')->value('id'),
        ]);
    }
}
