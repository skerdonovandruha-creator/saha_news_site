<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// справочник ролей: user, journalist, admin
class Role extends Model
{
    // эта модель не использует timestamps
    public $timestamps = false;

    protected $fillable = ['name'];

    // пользователи этой роли
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
