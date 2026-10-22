<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// статьи сайта
class Text extends Model
{
    // таблица texts — не texts
    protected $table = 'texts';

    protected $fillable = ['heading', 'text', 'category_id', 'user_id'];

    // к какой категории относится статья
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // кто автор статьи
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
