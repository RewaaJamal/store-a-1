@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between">
    <h1> Add Product </h1>
    <div>
      <a class="btn btn-outline-dark"  href="{{ route('admin.products.index') }}">Back</a> 
    </div>
</div>
 <form action = "{{ route('admin.products.store') }}" method="post" enctype = "multipart/form-data" >
   @include('admin.products._form')

  </form>
@endsection
