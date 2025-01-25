#### Route/Controller
> php artisan make:controller
- создаёт контроллер

```
Route::get("routeName", [
    ClassController::class,
    'handlerName'
]);
```
- связать контроллер с роутом

#### [Database](https://www.youtube.com/watch?v=IEcTcOb6Jok&list=PLd2_Os8Cj3t8pnG4ubQemoqnTwf0VFEtU&index=5)
Создавать нужно БД с кодировкой <b>utf8_general_ci</b>

База данных < (вмещает в себе) таблицы

Пока я не работаю с командной строкой для работы с БД можно юзать phpMyAdmin
(создать бд, выбрать кодировку) из пакета xampp и скачать отдельно
MySQL Workbench (операции с бд)

Устанавливая соединение в Workbench я соединясь с СУБД в целом, а не с отдельной БД (схемой)

> php artisan make:migration
- создаёт миграцию
> php artisan make:model -m
- создаёт модель и миграцию автоматически

Миграция - файл с описанием изменений, который подтягивает изменения структуры БД из проекта
в БД (?????????)


