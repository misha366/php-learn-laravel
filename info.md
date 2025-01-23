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
