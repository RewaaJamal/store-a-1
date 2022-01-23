@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between">
    <h1> products </h1>
    <div>
        @can('create-product')
        <a class="btn btn-outline-dark" href="{{ route('admin.products.create') }}">Create New</a> 
        @endcan
        <a class="btn btn-outline-danger" href="{{ route('admin.products.trash') }}">Trash</a> 
    </div>
</div>
@include('_alert')
 <form method="get" action="{{route('admin.products.index') }}"  class="form-inline">
    <input type="text" name="name" class="form-control" value = "{{$filters['name'] ?? '' }}">
    <select name ="category_id" class="form-control ml-1">
       <option value= "">All Categories </option>
       @foreach(App\Category::all() as $category)
       <option value="{{$category->id}}" @if($category->id == ( $filters['category_id'] ?? 0)) selected @endif>{{$category->name}}></option>
       @endforeach
    </select> 
    <button type="submit" class="btn btn-outline-dark">Find</button>
 </form>


 </form>   

    <table class="table">
        <thead>
            <tr>
                <th> </th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($product as $model)
            <tr>
                <td><img height="50"  src="{{ asset('storage/'. $model->image)  }}" alt=""></td>
                <td><a href="{{ route('admin.products.edit',[$model->id]) }}" > {{ $model->name}} </a> </td>
                <td>{{ $model->category->name}}</td>
                <td>{{$model->price}}</td>
                <td>{{$model->quantity}}</td>
                <td>{{ $model->created_at }}</td>
                <td>
                    @if($model->trashed())
                <form method="post" action = "{{ route('admin.products.restore',[$model->id]) }}" >
                     @method('put')
                     @csrf
                      <button type = "submit" class = "btn btn-outline-info">Restore</button>
                    </form>
                    @endif
                    <form method="post" action = "{{ route('admin.products.destroy',[$model->id]) }}" >
                     @method('delete')
                     @csrf
                      <button type = "submit" class = "btn btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    {{ $product->links() }}
@endsection    