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
@endsection
