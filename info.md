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

#### Bootstrap
https://www.youtube.com/watch?v=sdpaqoveghk&list=PLd2_Os8Cj3t8pnG4ubQemoqnTwf0VFEtU&index=17

#### Laravel соглашение по неймингу роутов
https://laravel.com/docs/11.x/controllers#actions-handled-by-resource-controllers

Структура: https://youtu.be/8VJ7tylaaFY?si=ZAFQAFIbn4X-axgS&t=383

#### Pluck
`$post->tags->pluck('title')->toArray()` - ф-я pluck автоматически извлекает нужные поля и формирует Collection
