@extends('layout')
@section('main-index')
<div>
  <div class="float-start">
    <h4 class="pb-3">Create Task</h4>
  </div>
  <div class="float-end">
      <a href="{{route('task.index')}}" class="btn btn-light border btn-sm">All Tasks</a>
  </div>
  <div class="clearfix"></div>
</div>
<div class="card card-body bg-light p-4">
  <form action="{{ route('task.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" class="form-control" id="description" rows="5"></textarea>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Status</label>
      <select name="status" id="status">
        @foreach($statuses as $status)
          <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-info text-white float-end">Save</button>
  </form>
</div>
@endsection