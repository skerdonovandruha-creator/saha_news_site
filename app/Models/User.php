<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    // какие поля можно заполнять массово
    protected $fillable = ['login', 'password', 'role_id'];

    // пароль не показывать при выводе модели
    protected $hidden = ['password'];

    // Laravel сам хеширует пароль при create()
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // к какой роли принадлежит пользователь
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // все статьи, написанные этим пользователем
    public function texts()
    {
        return $this->hasMany(Text::class);
    }
}
