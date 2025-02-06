<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - POSTS SITE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="container bg-body-secondary pb-3">

<div class="row">
    <nav>

        <ul>
            <li><a href="{{ route("main.home") }}">Home</a></li>
            <li><a href="{{ route("posts.index") }}">All Posts</a></li>
            <li><a href="{{ route("about.index") }}">About</a></li>
        </ul>
    </nav>
</div>

@if (Auth::check())
    <div class="float">
        <div class="float__circle btn btn-success">
            <a href="{{ route("posts.create") }}" class="float__link">
                    <span class="float__link-wrapper">
                        ADD
                    </span>
            </a>
        </div>
    </div>
@endif

{{-- AUTH CANVAS --}}
@php
    $isAuthorized = true;
    $isAdmin = false;
@endphp

<button class="menu__button-user btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
        aria-controls="offcanvasMenu">
    User Menu
</button>
@if($isAuthorized && $isAdmin)
    <a href="#" class="menu__button-admin btn btn-danger">
        Admin Panel
    </a>
@endif

<span class="menu__line {{ $isAuthorized &&  $isAdmin ? "bg-danger" : "bg-primary" }}"></span>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">


    @if($isAuthorized)
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Меню пользователя</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Закрыть"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex align-items-center mb-3">
                <img
                    src="{{ asset("images/young-handsome-man-beard-wearing-260nw-1763585303.webp") }}"
                    alt="Аватарка"
                    class="offcanvas__profile-photo"
                >
                <div>
                    <h6 class="mb-0">Имя пользователя</h6>
                    <small class="text-muted">user@email.com</small>
                </div>
            </div>
            <ul class="list-group mb-3">
                <li class="list-group-item"><a class="offcanvas__auth-link" href=""><i class="bi bi-house-door me-2"></i> Главная</a></li>
                <li class="list-group-item"><a class="offcanvas__auth-link" href=""><i class="bi bi-person me-2"></i> Профиль</a></li>
                <li class="list-group-item"><a class="offcanvas__auth-link" href=""><i class="bi bi-gear me-2"></i> Настройки</a></li>
                <li class="list-group-item"><a class="offcanvas__auth-link" href=""><i class="bi bi-box-arrow-right me-2"></i> Выйти</a></li>
            </ul>
            <div class="mt-auto">
                <small class="text-muted">Версия 1.0.0</small>
            </div>
        </div>
    @else
        <div class="p-5 d-flex justify-content-center align-items-center flex-column h-100">
            <a class="mb-3 btn btn-primary w-100" href="#">Login</a>
            <a class="btn btn-outline-primary w-100" href="#">Sign Up</a>
        </div>
    @endif
</div>

{{-- /AUTH CANVAS --}}

<div class="row">
    @yield("content")
</div>
</body>
</html>
