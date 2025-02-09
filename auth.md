# Auth implementation

Юзать Jetstream на проектах не надо, это буквально одина из худших библиотек по аутентификации


Jetstream routes:
```plaintext
GET|HEAD  dashboard                        dashboard
GET|HEAD  forgot-password                  password.request › PasswordResetLinkController@create
POST      forgot-password                  password.email › PasswordResetLinkController@store
GET|HEAD  login                            login › AuthenticatedSessionController@create
POST      login                            login.store › AuthenticatedSessionController@store
POST      logout                           logout › AuthenticatedSessionController@destroy
GET|HEAD  register                         register › RegisteredUserController@create
POST      register                         register.store › RegisteredUserController@store
POST      reset-password                   password.update › NewPasswordController@store
GET|HEAD  reset-password/{token}           password.reset › NewPasswordController@create
GET|HEAD  two-factor-challenge             two-factor.login › TwoFactorAuthenticatedSessionController@create
POST      two-factor-challenge             two-factor.login.store › TwoFactorAuthenticatedSessionController@store
GET|HEAD  user/confirm-password            password.confirm › ConfirmablePasswordController@show
POST      user/confirm-password            password.confirm.store › ConfirmablePasswordController@store
GET|HEAD  user/confirmed-password-status   password.confirmation › ConfirmedPasswordStatusController@show
PUT       user/password                    user-password.update › PasswordController@update
GET|HEAD  user/profile                     profile.show › UserProfileController@show
PUT       user/profile-information         user-profile-information.update › ProfileInformationController@update
POST      user/two-factor-authentication   two-factor.enable › TwoFactorAuthenticationController@store
DELETE    user/two-factor-authentication   two-factor.disable › TwoFactorAuthenticationController@destroy
GET|HEAD  user/two-factor-qr-code          two-factor.qr-code › TwoFactorQrCodeController@show
GET|HEAD  user/two-factor-recovery-codes   two-factor.recovery-codes › RecoveryCodeController@index
POST      user/two-factor-recovery-codes   RecoveryCodeController@store
GET|HEAD  user/two-factor-secret-key       two-factor.secret-key › TwoFactorSecretKeyController@show
```

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

### 2. Кастомизировать auth страницы
Основные страницы:

`auth/login.blade.php` — Страница входа
`auth/register.blade.php` — Страница регистрации
`auth/forgot-password.blade.php` — Восстановление пароля

Страницы надо будет переписывать, надо смотреть в таблицу роутов и там
где GET запрос переписывать страничку под свои стили.

Если же какой-то функционал излишний данный роут следует просто отключить.

Базовые бутстрап шаблоны под каждый роут:
1. [Dashboard](https://gist.github.com/misha366/7765c9142deaff2ae637b175f6272c89)
   - Dashboard юзлесс, полностью вырезаем из программы, всё редиректим на страницу профиля
   - Из класса web.php удалить маршрут на /dashboard:
    ```php
    // Помимо того что уберёт роут ещё и удалит из листа роутов
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
    //    Route::get('/dashboard', function () {
    //        return view('dashboard');
    //    })->name('dashboard');
    });
    ```
    - Меняем хоум роут в конфигурациях (fortify.php, RouteServiceProvider):
    ```php
    'home' => '/dashboard', (было)
        |
       \|/
    'home' => '/user/profile', (стало)
    ```

    ```php
    public const HOME = '/dashboard';, (было)
        |
       \|/
    public const HOME = '/user/profile';, (стало)
    ```

    - Удаляем `dashboard.blade.php`
    - Удаляем из `navigation-menu.blade.php` упоминание dashboard
    - Чистим кеш, проверяем роуты
    ```plaintext
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    
    php artisan route:list
    ```
2. [Profile](https://github.com/misha366/php-learn-laravel/tree/00e0fc8006afcb8af479f0f7e0774005ebe86ee4/resources/views/profile)
Как загружать картинки?

С коробки на странице профиля есть неисправный блок - менеджмент сессий,
он не работает и даже если бы работал был бы не безопасным, поэтому его
надо сразу удалять:
- Удалить из `profile/show.blade.php`
```plaintext
@livewire('profile.logout-other-browser-sessions-form')
```
- Удалить `profile/logout-other-browser-sessions-form.blade.php`

3. [Auth pages](#)

// пока что не исполнять всё что снизу

Удалять:
`View/Components`

`components/`

``

Лучше пусть висит, тк в будущем можно заюзать:
`emails/`

`api/`

(роуты скрыты)

`policy.blade.php`

`terms.blade.php`


Нужно удалить папку View/Components с `AppLayout.php` и `GuestLayout.php`.
Дальше нужно удалить все лейауты и не нужные компоненты.


