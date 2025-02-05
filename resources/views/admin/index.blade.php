@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container-fluid">
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body d-flex justify-content-between">
                    <div class="flex-grow-1 d-flex flex-column">
                        <h3 class="display-5 flex-grow-1">
                            <a href="">#1 - {{ $post->title }}</a>
                        </h3>
                        <p class="card-text text-muted small">
                            <a href="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, minima!</a>
                        </p>
                    </div>
                    <div class="d-flex flex-column align-items-end">
                        <a class="btn btn-primary btn-sm mb-2" href="#">Edit</a>
                        <form method="POST">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
