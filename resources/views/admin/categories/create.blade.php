@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between">
    <h1> Add Category </h1>
    <div>
      <a class="btn btn-outline-dark"  href="{{ route('admin.categories.index') }}">Back</a> 
    </div>
</div>
 <form action = "{{ route('admin.categories.store') }}" method="post" enctype = "multipart/form-data" >
   @include('admin.categories._form')

  </form>
@endsection
