@extends('layouts.app')
@section('title', trans('messages.productPage'))

@section('content')

    <div class="container">
        <h3>{{ trans('messages.productPage') }}</h3>
        @csrf
        @if ($destination == 'addProduct')
            <form action="{{ route('addProduct') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" placeholder="{{ trans('messages.title') }} " value="{{ old('title') }}">
                @error('title')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <input type="text" name="description" placeholder="{{ trans('messages.description') }} "
                    value="{{ old('description') }}">
                @error('description')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <input type="text" name="price" placeholder="{{ trans('messages.price') }} "
                    value="{{ old('price') }}">
                @error('price')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <input type="file" name="image" id="file" class="inputFile">
                @error('image')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <a href="{{ route('products') }}">{{ trans('messages.productsPage') }}</a>
                <input type="submit" name="save" value="{{ trans('messages.save') }}">
            </form>
        @elseif ($destination == 'editProduct')
            <form action="{{ route('update', [$product->id]) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <input type="text" name="title" placeholder="{{ trans('messages.title') }} "
                    value="{{ old('title') ? old('title') : $product->title }}">
                @error('title')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <input type="text" name="description" placeholder="{{ trans('messages.description') }} "
                    value="{{ old('description') ? old('description') : $product->description }}">
                @error('description')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <input type="text" name="price" placeholder="{{ trans('messages.price') }} "
                    value="{{ old('price') ? old('price') : $product->price }}">
                @error('price')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <input type="file" name="image" id="file" class="inputFile">
                @error('image')
                    <p style="color:red;">{{ $message }}</p>
                @enderror
                <br>
                <br>
                <a href="{{ route('products') }}">{{ trans('messages.productsPage') }}</a>
                <input type="submit" name="save" value="{{ trans('messages.save') }}">
            </form>
        @endif

    </div>

@endsection
