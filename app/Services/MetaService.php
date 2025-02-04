<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Tag;

class MetaService
{
    // Мета - данные связанные с постами, но постами не являющиеся

    public function getCategoriesAndTags() : array {
        $categories = Category::all();
        $tags = Tag::all();

        return [
            "categories" => $categories,
            "tags" => $tags
        ];
    }

}
