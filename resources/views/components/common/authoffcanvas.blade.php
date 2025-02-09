
@php
    $isAuthorized = Auth::check();
    $isAdmin = auth()->user()?->role->name === "ROLE_ADMIN";
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
                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </div>
            </div>
            <ul class="list-group mb-3">
                <li class="list-group-item"><a class="offcanvas__auth-link" href="{{ route("main.home") }}"><i class="bi bi-house-door me-2"></i> Главная</a></li>
                <li class="list-group-item"><a class="offcanvas__auth-link" href="{{ route("profile.show") }}"><i class="bi bi-person me-2"></i> Профиль</a></li>
                <li class="list-group-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="offcanvas__auth-button">
                                <i class="bi bi-box-arrow-right me-2"></i> Выйти
                        </button>
                    </form>
                </li>
            </ul>
            <div class="mt-auto">
                <small class="text-muted">Версия 1.0.0</small>
            </div>
        </div>
    @else
        <div class="p-5 d-flex justify-content-center align-items-center flex-column h-100">
            <a class="mb-3 btn btn-primary w-100" href="{{ route("login") }}">Login</a>
            <a class="btn btn-outline-primary w-100" href="{{ route("register") }}">Sign Up</a>
        </div>
    @endif
</div>
