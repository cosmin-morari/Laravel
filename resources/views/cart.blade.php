<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>{{ trans('messages.cartPage') }}</title>
</head>

<body>
    <div class="container">
        <h1>{{ trans('messages.cartPage') }}</h1>
            @if (isset($products))
                
            @foreach ($products as $product)

            <div class="content">
                <form action="#" method="POST">
                    @csrf
                    <div class="img">
                        <img src="{{ asset('photos/' . $product->imageSource) }}" alt="">
                    </div>
                    <div class="details">
                        <p>{{ trans('messages.title') }}:{{ $product->title }}</p>
                        <p>{{ trans('messages.description') }}:{{ $product->description }}</p>
                        <p>{{ trans('messages.price') }}:{{ $product->price }}</p>
                    </div>
                    <div class="addToCart">
                        <a href="{{ url('deleteProduct/' . $product->id) }}">{{ trans('messages.delete') }}</a>
                    </div>
                </form>
            </div>
        @endforeach
            @else
                {{ $empty}}
            @endif
        <div class="links">
            <a href="{{ route('index') }}">{{ trans('messages.index') }}</a>
        </div>
    </div>
</body>

</html>
<?php



// session()->flush();