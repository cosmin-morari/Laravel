@include('layouts.header')
<title>{{ trans('messages.index') }}</title>

<body>


    <div class="container">
        <h1>{{ trans('messages.index') }}</h1>
        @foreach ($allProducts as $product)
            <div class="content">
                <form action="{{ route('addToCart', [$product->id]) }}" method="POST">
                    @csrf
                    <div class="img">
                        <img src="{{ asset('storage/photos/' . $product->imageSource) }}" alt="">
                    </div>
                    <div class="details">
                        <p>{{ trans('messages.title') }}:{{ $product->title }}</p>
                        <p>{{ trans('messages.description') }}:{{ $product->description }}</p>
                        <p>{{ trans('messages.price') }}:{{ $product->price }}</p>
                    </div>
                    <div class="addToCart">
                        <button type="submit" class="addToCartBtn">{{ trans('messages.add') }}</button>
                    </div>
                </form>
            </div>
        @endforeach
        <div class="links">
            <a href="{{ route('cart') }}">{{ trans('messages.cart') }}</a>
        </div>
    </div>

    @include('layouts.footer')
