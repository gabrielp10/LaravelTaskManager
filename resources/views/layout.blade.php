<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
      
      <title>Laravel Task Manager</title>
  </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{ route('task.index') }}" title="Laravel Task Manager">L. Task Manager</a>
            </div>
          </nav>
        <div class="container p-5">
          @yield('main-index')
        </div>
        @extends('footer')
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>


