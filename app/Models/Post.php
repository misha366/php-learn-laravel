<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, "category_id", "id");
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            "post_tags",
            "post_id",
            "tag_id"
        );
    }

    protected $fillable = [
        "title",
        "content",
        "image",
        "category_id"
    ];
}
