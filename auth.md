# Auth implementation

### 1. Добавить кастомные роли

- Создать таблицу ролей
> php artisan make:model Role -m
```php
// ROLE_VISITOR всегда старайся делать первым индексом
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```

- Создать миграцию для users, в которой добавим fk на roles
> php artisan make:migration add_role_id_to_users_table
```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('role_id')
            ->nullable()
            ->constrained('roles')
            ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['role_id']);
        $table->dropColumn('role_id');
    });
}
```

- добавим связи в модели
```php
public function users(): HasMany {
    return $this->hasMany(User::class, 'role_id', 'id');
}

public function role(): BelongsTo {
    return $this->belongsTo(Role::class, 'role_id', 'id');
}
```

- добавим сидер для ролей
> php artisan make:seeder RoleSeeder
```php
public function run(): void
{
    Role::create([
        "name" => "ROLE_VISITOR",
    ]);
    Role::create([
        "name" => "ROLE_AUTHOR",
    ]);
    Role::create([
        "name" => "ROLE_ADMIN",
    ]);
}
```

- добавим сидер для юзеров
> php artisan make:seeder UserSeeder
```php
public function run(): void
    {
        $faker = Faker::create();

        User::create([
            'name' => 'user_visitor',
            'email' => 'user_visitor@gmail.com',
            'password' => 'password',
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'user_author',
            'email' => 'user_author@gmail.com',
            'password' => 'password',
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'user_admin',
            'email' => 'user_admin@gmail.com',
            'password' => 'password',
            'role_id' => 3,
        ]);

        for ($i = 0; $i < 17; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => 'password',
                'role_id' => rand(1, 2),
            ]);
        }
    }
```

- добавим оба сидера в `DatabaseSeeder.php`
```php
$this->call([
    CategorySeeder::class,
    TagSeeder::class,
    PostSeeder::class,
    RoleSeeder::class,
    UserSeeder::class
]);
```
