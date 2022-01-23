@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between">
    <h1> Categories </h1>
    <div>
    <a class="btn btn-outline-dark" href="{{ route('admin.roles.create') }}">Create New</a> 
    </div>
</div>
@include('_alert')
@if(session()->has('message'))
    <div class="alert alert-success">
       {{ session()->get('message')}}
    </div>   
@endif        


    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roles as $model)
            <tr>
                <td><a href="{{ route('admin.roles.edit',[$model->id]) }}" > {{ $model->name}} </a> </td>
                <td>{{ $model->created_at }}</td>
                <td><form method="post" action = "{{ route('admin.roles.destroy',[$model->id]) }}" >
                     @method('delete')
                     @csrf
                      <button type = "submit" class = "btn btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
@endsection    