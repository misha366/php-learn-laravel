@php
    $isAuthorOrHigher = in_array(auth()->user()?->role->name, ["ROLE_AUTHOR", "ROLE_ADMIN"]);
@endphp

@if($isAuthorOrHigher)
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
