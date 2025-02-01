<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // Теперь можно написать $category->posts и будут отображены посты категории
    // https://youtu.be/sgL1bQf19Nc?si=YmkgQB0JGr2xSh-1&t=959
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
