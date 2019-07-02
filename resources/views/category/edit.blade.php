@extends('home')

@section('content')
<div class="card">
    <div class="card-header text-center">
       Edit category {{ $objCat->id ?? old('id') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/category/modify') }}">
            {{-- crear dos campos ocultos para prevenir el ataque CSRF --}}
            {{-- https://es.wikipedia.org/wiki/Cross-site_request_forgery --}}
            {{ method_field('POST') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Name *:</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') ?? $objCat->name }}" />
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') ?? $objCat->description }}</textarea>
            </div>

            <div class="form-group">                
                <button class="btn btn-success" type="submit" name="action" value="update">update</button>
                <button class="btn btn-danger" type="submit" name="action" value="delete">delete</button>
                <button class="btn btn-warning" type="reset">reset</button>
                <a class="btn btn-dark" href="{{ url('/category/edit/' . (old('id') ?? $objCat->id)) }}">reload</a>
            </div>

            <label class="alert alert-light">* Required fields</label>
            <input type="hidden" id="id" name="id" value="{{ old('id') ?? $objCat->id }}">
        </form>
    </div>
</div>
@stop

@section('message')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @isset($message)
        <div class="alert alert-warning">
            {{ $message }}
        </div>
    @endisset
@stop

