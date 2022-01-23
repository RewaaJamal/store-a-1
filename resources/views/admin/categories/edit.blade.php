@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between">
    <h1> Edit Category </h1>
    <div>
      <a class="btn btn-outline-dark"  href="{{ route('admin.categories.index') }}">Back</a> 
    </div>
</div>
  <form action = "{{ route('admin.categories.update',[$category->id]) }}" method="post" enctype="multipart/form-data" >
  @method('put')
  @include('admin.categories._form')
  </form>
@endsection