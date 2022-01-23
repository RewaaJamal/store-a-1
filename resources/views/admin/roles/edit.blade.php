@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between">
    <h1> Edit Role </h1>
    <div>
      <a class="btn btn-outline-dark"  href="{{ route('admin.roles.index') }}">Back</a> 
    </div>
</div>
  <form action = "{{ route('admin.roles.update',[$role->id]) }}" method="post" enctype="multipart/form-data" >
  @method('put')
  @include('admin.roles._form')
  </form>
@endsection