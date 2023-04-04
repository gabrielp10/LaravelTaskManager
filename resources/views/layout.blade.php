<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Task Controller</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

        
    </head>
    <div id="app">
      <search-tasks></search-tasks>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <body class="antialiased">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{ route('task.index') }}">L. Task Manager</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                  <li class="nav-item">
                    <a class="nav-link fw-bold" href="{{ route('task.create') }}">New Task</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
                <form class="d-flex">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search-input">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
              </div>
            </div>
          </nav>
        {{-- Body --}}
        <div class="container p-5">
          @yield('main-index')
        </div>
        @extends('footer')
    </body>
</html>
<script>
  function searchTasks() {
      let query = document.getElementById('search-input').value;
      let url = '{{ route('task.search') }}?query=' + encodeURIComponent(query);

      fetch(url)
          .then(response => response.json())
          .then(data => {
              let tasks = data.tasks;
              let html = '';
  
              if (tasks.length === 0) {
                  html = '<div class="alert alert-danger p-2 text-center">No Tasks found</div>';
                  html += '<div class="container">';
                  html += '<div class="card-body d-flex justify-content-center">';
                  html += '<a href="{{route('task.create')}}" class="btn btn-info">Create Task</a>';
                  html += '</div>';
                  html += '</div>';
              } else {
                  tasks.forEach(task => {
                      let badgeClass = task.status === 'To-do' ? 'bg-info text-dark' : 'bg-success text-white';
                      let badgeText = task.status === 'To-do' ? 'To-do' : 'Done';
                      html += '<div class="card-header">';
                      html += '<span class="fw-bolder">' + task.title + '</span>';
                      html += '<span class="badge bg-warning">' + task.created_at_formatted + '</span>';
                      html += '<small>Last updated - ' + task.updated_at_formatted + '</small>';
                      html += '</div>';
                      html += '<div class="row">';
                      html += '<div class="col-9">';
                      html += '<div class="card-body">';
                      html += '<div class="card-text">' + task.description + '</div>';
                      html += '<br>';
                      html += '<span class="badge ' + badgeClass + '">' + badgeText + '</span>';
                      html += '</div>';
                      html += '</div>';
                      html += '<div class="col-3 d-flex align-items-center justify-content-end">';
                      html += '<a href="{{ route('task.edit', ':id')}}" class="btn btn-sm btn-success d-inline">✏️ Edit</a>';
                      html += '<form action="{{ route('task.destroy', ':id') }}" class="d-inline" method="POST">';
                      html += '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
                      html += '<input type="hidden" name="_method" value="DELETE">';
                      html += '<button type="submit" class="btn btn-sm btn-danger mx-2">🗑️ Delete</button>';
                      html += '</form>';
                      html += '</div>';
                      html += '</div>';
                      html += '<div class="clearfix"></div>';
                      html = html.replace(/:id/g, task.id); // Substitua o marcador :id pelo ID da tarefa
                  });
              }

              let container = document.querySelector('.card.card-body.bg-light.p-4');
              container.innerHTML = html;
          });
      }

      // Encontre o formulário de pesquisa
      const searchForm = document.querySelector('form');

      // Adicione um eventListener para o evento 'submit'
      searchForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir o comportamento padrão de atualizar a página
        searchTasks(); // Chamar a função de pesquisa
      });

      function formatDate(date) {
        return moment(date).fromNow();
      }

</script>

