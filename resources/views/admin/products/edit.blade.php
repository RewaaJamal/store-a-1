@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between">
    <h1> Edit Product </h1>
    <div>
      <a class="btn btn-outline-dark"  href="{{ route('admin.products.index') }}">Back</a> 
    </div>
</div>
  <form action = "{{ route('admin.products.update',[$product->id]) }}" method="post" enctype="multipart/form-data" >
  @method('put')
  @include('admin.products._form')
  </form>
@endsection