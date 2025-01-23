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

#### Database
Создавать нужно БД с кодировкой <b>utf8_general_ci</b>

База данных < (вмещает в себе) таблицы

Пока я не работаю с командной строкой для работы с БД можно юзать phpMyAdmin
(создать бд, выбрать кодировку) из пакета xampp и скачать отдельно
MySQL Workbench (операции с бд)

Устанавливая соединение в Workbench я соединясь с СУБД в целом, а не с отдельной БД (схемой)
