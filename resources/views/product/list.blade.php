
@extends('home')

@section('content')
    @isset($arrProd)
   
    <div class="card">
        <div class="card-header text-center">
           List product
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <tr class="thead-dark">
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                </tr>
                @foreach ($arrProd as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        @isset($product->category)
                        <td>{{ $product->Category->name}}</td>
                        @endisset
                    </tr> 
                @endforeach
            </table>
        </div>
    @endisset
@stop

@section('message')
    @if(isset($message))
        <div class="alert alert-warning">
            {{ $message }}
        </div>
    @endif
@stop


