@extends('layout')
@section('main-index')
<div>
  <div class="float-start">
    <h4 class="pb-3">My Tasks</h4>
  </div>
  <div class="clearfix"></div>
</div>
<div class="card card-body bg-light p-4">
  @foreach ($tasks as $task)
    <div class="card-header">
      <span class="fw-bolder">{{ $task->title }}</span>
      <span class="badge bg-warning text-dark">{{ $task->created_at->diffforHumans() }}</span>
      <small>Last updated - {{ $task->updated_at->diffforHumans() }}</small>
    </div>
    <div class="row">
      <div class="col-9">
        <div class="card-body">
          <div class="card-text">{{ $task->description }}</div>
          <br>
          @if ($task->status === "To-do")
            <span class="badge bg-info text-dark">To-do</span>
          @else
            <span class="badge bg-success text-white">Done</span>
          @endif
        </div>
      </div>
      <div class="col-3 d-flex align-items-center justify-content-end">
        <a href="{{ route('task.edit', $task->id )}}" class="btn btn-sm btn-success d-inline">✏️ Edit</a>
        <form action="{{ route('task.destroy', $task->id) }}" class="d-inline" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger mx-2">🗑️ Delete</button>
          
        </form>
      </div>
    </div>
    <div class="clearfix"></div>
  @endforeach
  @if (count($tasks) === 0)
    <div class="alert alert-danger p-2 text-center">No Tasks found</div>
    <div class="container">
      <div class="card-body d-flex justify-content-center">
        <a href="{{route('task.create')}}" class="btn btn-info">Create Task</a>
      </div>
    </div>
  @endif
</div>
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
                      html += '<span class="badge ' + badgeClass + '">' + task.created_at.diffforHumans() + '</span>';
                      html += '<small>Last updated - ' + task.updated_at.diffforHumans() + '</small>';
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
</script>
@endsection
