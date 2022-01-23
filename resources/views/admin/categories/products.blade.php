@extends('layouts.admin')
@section('content')

<div class="d-flex justify-content-between">
    <h1> {{ $category->name }} </h1>
    <div>
    <a class="btn btn-outline-dark" href="{{ route('admin.categories.index') }}">Back</a> 
    </div>
</div>
@include('_alert')        


    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
        @foreach($category->products as $product)
            <tr>
                <td>{{ $product->name}}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->created_at }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
@endsection    