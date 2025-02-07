#### Laravel
`dd();` - аналог var_dump от laravel, который кладёт
скрипт после вывода информации о переданном объекте

`dump();` - делает то же самое, но не кладёт скрипт

#### Route/Controller
> php artisan make:controller
- создаёт контроллер

```
Route::get("routeName", [
    ClassController::class,
    "handlerName"
]);
```
- связать контроллер с роутом

#### Migrations
Создавать нужно БД с кодировкой <b>utf8_general_ci</b>

База данных < (вмещает в себе) таблицы

Пока я не работаю с командной строкой для работы с БД можно юзать phpMyAdmin
(создать бд, выбрать кодировку) из пакета xampp и скачать отдельно
MySQL Workbench (операции с бд)

Устанавливая соединение в Workbench я соединясь с СУБД в целом, а не с отдельной БД (схемой)

> php artisan make:migration
- создаёт миграцию
> php artisan migrate
- накатывает миграцию
> php artisan make:model -m
- создаёт модель и миграцию автоматически

[Миграция](https://www.youtube.com/watch?v=IEcTcOb6Jok&list=PLd2_Os8Cj3t8pnG4ubQemoqnTwf0VFEtU&index=5) -
файл с описанием изменений, который подтягивает изменения структуры БД из проекта
в БД

У миграции есть 2 метода - up и down, которые позволяют накатывать миграцию (переносить изменения
с модели в бд) и откатывать миграции (удалять добавленные изменения в БД).
Миграции актуальны только во время разработки проекта

Данные от БД указывать в ./.env

Все данные о совершённых миграциях хранятся в таблице этого же проекта - `migrations`

#### IDE tips
дабл шифт - глобальный поиск

#### Model

Retrieving - вытягивать

Для работы с моделями у laravel есть 2 подхода:
- Eloquent ORM (более высокоуровневый вариант)
- Database (более низкоуровневый вариант)

`Model::find(int id)` - сделать запрос в БД по ид

!!`Model::findOrFail(int id)` - сделать запрос в БД по ид и кинуть исключение 404 вместо null,
если в ответе ничего нету

`Model::all()` - возвращает все строки из БД в виде Collection

`Model::where("column", "value")->get()` - запрос в БД с WHERE
- <b>метод ->get() всегда оборачивает результат в коллекцию</b>
- <b>метод ->first() выбирает самую первую строку результата</b>

`Model::updateOrCreate([controlAttr], [newAttr])` - делает запрос в бд по контрольным аттрибутам
если будет найдена нужна строка, то перезапишет её контрольным значением, если нет, то создаст экземпляр
из аттрибутов newAttr

`Model::firstOrCreate([controlAttr], [newAttr])` - делает запрос в бд по контрольным аттрибутам
если будет найдена нужна строка, то вернёт её, если нет, то создаст из аттрибутов newAttr

#### Laravel Validation
```
public function createPost(Request $request) : JsonResponse {
    $validated = $request->validate([
        "title" => "required|string|max:255",
        "content" => "required|string",
        "image" => "nullable|string"
    ]);
```
#### Laravel соглашение по неймингу роутов
https://laravel.com/docs/11.x/controllers#actions-handled-by-resource-controllers

Структура: https://youtu.be/8VJ7tylaaFY?si=ZAFQAFIbn4X-axgS&t=383

#### Pluck
`$post->tags->pluck('title')->toArray()` - ф-я pluck автоматически извлекает нужные поля и формирует Collection

#### Однометодные контроллера
Однометодные контроллеры пишутся через маг. метод __invoke()

#### FormRequest
https://www.youtube.com/watch?v=Es0K66she5Q&list=PLd2_Os8Cj3t8pnG4ubQemoqnTwf0VFEtU&index=27

Реквесты некое подобие дто для приёма данных, инструмент для того чтобы
вынести логику принятие данных в отдельный класс

> php artisan make:request Post/StoreRequest

Авторайз надо переключать на тру

<b>Если мы используем валидацию через класс, то она происходит, ДО запуска акшна</b>
Решением будет использовать метод `prepareForValidatio()` в котором можно преобразовать 
пустое значение непосредственно в null

```
public function prepareForValidation() : void {
    $this->merge([
        "category_id" => $this->category_id === "null" ? null : $this->category_id,
        "image" => $this->image === "" ? null : $this->image
    ]);
}
```
Но в валидатор сам конвертирует пустую строку в null, поэтому в этой ситуации данный код юзлесс

#### Services
https://www.youtube.com/watch?v=GssEIvK3Is0&list=PLd2_Os8Cj3t8pnG4ubQemoqnTwf0VFEtU&index=28

Слой с сервисами надо внедрять в сложных проектах, только когда действительно становится сложно читать код

#### Factory и seed
Инструменты для создания dump даты в ларавел

#### Pagination style
> php artisan vendor:publish --tag=laravel-pagination
https://www.youtube.com/watch?v=m6b8OUjDXgs&list=PLd2_Os8Cj3t8pnG4ubQemoqnTwf0VFEtU&index=30

Для того чтобы заюзать пагинацию нужно доставать посты с помощью `::paginate(step)`,
потом нужно просто указать в шаблоне `{{ $posts->links() }}` и ларавел сам подтянет компонент
пагинации. При нужде этот шаблон можно написать самому.

#### Бизнес логика в сервисах
Когда стоит выносить в сервис?

Сервис нужен, если:

Логика усложняется — например, если вам нужно не просто получить все категории и теги, а сделать сложный
*запрос с фильтрацией, объединением и проверками.*

Переиспользование — если та же логика нужна в другом месте, например, в админке или в API.

Разгрузка контроллера — когда метод контроллера становится слишком длинным.

P. S. т. е. не надо выносить абсолютно всё в сервис, нужно выносить действительно что-то сложное

#### Repository
Интерфейс юзаем потому что в будущем можем юзать другую бд, в другой реализации

Репозиторий надо регистрировать в AppServiceProvider:
``

#### Исключения и логи
Создавать кастомные исключения и логировать их - хорошая практика

Чтобы логировать свою сущность (в примере пост) нужно в logging.php в channels указать:
```
'post' => [
    'driver' => 'single',
    'path' => storage_path('logs/posts.log'),
    'level' => 'error',
],
```
Логи будут в storage/logs

#### Bootstrap
> npm install bootstrap @popperjs/core

resources/js/app.js
```
import 'bootstrap';
import '../css/app.css';
```

resources/css/app.css
```
@import "bootstrap/dist/css/bootstrap.min.css";
```

```
<title>Laravel</title>
@vite(['resources/js/app.js'])
```

`npm run dev`

#### Seeder
> php artisan make:refresh
> php artisan db:seed

#### Удалить fk
```php
$table->dropForeign(['category_id']);
$table->dropColumn('category_id');
```

#### Jetstream auth
```
composer require laravel/jetstream
php artisan jetstream:install livewire
npm install && npm run dev
php artisan migrate
```

Чтобы удалить tailwind, который подтягивает jetstream надо
1. Редактировать `app.css`, его изменит jetstream, добавив tailwind
2. > npm uninstall tailwindcss
3. `tailwind.config.js` - удалить
4. > npm install
5. > npm run build --force
6. > npm run dev
