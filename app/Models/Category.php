<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// категории: Технологии, Космос и т.д.
class Category extends Model
{
    // без timestamps — это справочник
    public $timestamps = false;

    protected $fillable = ['name'];

    // статьи этой категории
    public function texts()
    {
        return $this->hasMany(Text::class);
    }
}
