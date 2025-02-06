# php-learn-laravel

adminlte 3.14.3
jetstream 4.3.1

### Models
<b>Post</b>
```plaintext
Post {
    (1)    
    id            bigint(20) unsigned  (Primary Key, Auto Increment)
    title         string(255)          (Название поста, обязательное)
    content       text                 (Содержимое поста, обязательное)
    image         string(255) NULL     (Изображение, необязательное)
    likes         bigint(20) unsigned  (Количество лайков, по умолчанию 0)
    is_published  tinyint(1)           (Флаг публикации, по умолчанию 0)
    created_at    timestamp NULL       (Дата создания)
    updated_at    timestamp NULL       (Дата обновления)
    (2)
    deleted_at    timestamp NULL       (Реализация Soft Delete)
    (3)
    category_id   bigint(20) unsigned  (Внешний ключ на категорию)
}
```
Migrations:
1. [2025_01_25_000907_create_posts_table.php](https://github.com/misha366/php-learn-laravel/blob/master/database/migrations/2025_01_25_000907_create_posts_table.php)
2. [2025_01_28_195659_add_softdelete_to_posts_table.php](https://github.com/misha366/php-learn-laravel/blob/master/database/migrations/2025_01_28_195659_add_softdelete_to_posts_table.php)
3. [2025_02_01_075131_add_category_id_to_posts_table.php
   ](https://github.com/misha366/php-learn-laravel/blob/master/database/migrations/2025_02_01_075131_add_category_id_to_posts_table.php)

<b>Category</b>
```plaintext
Category {
    (1)
    id         bigint(20) unsigned  (Primary Key, Auto Increment)
    title      string(255)          (Название категории, обязательное)
    created_at timestamp NULL       (Дата создания)
    updated_at timestamp NULL       (Дата обновления)
}
```
Migrations:
1. [2025_02_01_074217_create_categories_table.php](https://github.com/misha366/php-learn-laravel/blob/master/database/migrations/2025_02_01_074217_create_categories_table.php)

<b>Tag</b>
```plaintext
Tag {
    (1)
    id         bigint(20) unsigned  (Primary Key, Auto Increment)
    title      string(255)          (Название тега, обязательное)
    created_at timestamp NULL       (Дата создания)
    updated_at timestamp NULL       (Дата обновления)
}
```
Migrations:
1. [2025_02_01_203901_create_tags_table.php](https://github.com/misha366/php-learn-laravel/blob/master/database/migrations/2025_02_01_203901_create_tags_table.php)

<b>PostTag</b> (Post to Tag (many-to-many) relation)
```plaintext
PostTag {
    (1)
    id         bigint(20) unsigned  (Primary Key, Auto Increment)
    post_id    bigint(20) unsigned  (Внешний ключ на пост)
    tag_id     bigint(20) unsigned  (Внешний ключ на тег)
    created_at timestamp NULL       (Дата создания)
    updated_at timestamp NULL       (Дата обновления)
}
```
Migrations:
1. [2025_02_01_204539_create_post_tags_table.php](https://github.com/misha366/php-learn-laravel/blob/master/database/migrations/2025_02_01_204539_create_post_tags_table.php)
