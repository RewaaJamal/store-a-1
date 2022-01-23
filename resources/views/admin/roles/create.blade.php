@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between">
    <h1> Add Role </h1>
    <div>
      <a class="btn btn-outline-dark"  href="{{ route('admin.roles.index') }}">Back</a> 
    </div>
</div>
 <form action = "{{ route('admin.roles.store') }}" method="post" enctype = "multipart/form-data" >
   @include('admin.roles._form',[
    'role'=> new App\Models\Role(),
    ])

  </form>
@endsection
