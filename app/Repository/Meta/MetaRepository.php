<?php

namespace App\Repository\Meta;

use App\Models\Category;
use App\Models\Tag;

class MetaRepository implements MetaRepositoryInterface
{
    public function getCategoriesAndTags(): array
    {
        $categories = Category::all();
        $tags = Tag::all();

        return [
            "categories" => $categories,
            "tags" => $tags
        ];
    }

}
