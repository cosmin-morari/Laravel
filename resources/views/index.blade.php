<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>{{trans('messages.index')}}</title>
</head>

<body>
    <div class="container">
        <h1>{{trans('messages.index')}}</h1>
        @foreach ($allProducts as $product)
            <div class="content">
                <form action="#" method="POST">
                    @csrf
                    <div class="img">
                        <img src="{{asset('photos/'.$product->imageSource)}}" alt="">
                    </div>
                    <div class="details">
                        <p>{{trans('messages.title')}}:{{$product->title}}</p>
                        <p>{{trans('messages.description')}}:{{$product->description}}</p>
                        <p>{{trans('messages.price')}}:{{$product->price}}</p>
                    </div>
                    <div class="addToCart">
                        <button type="submit" class="addToCartBtn">{{trans('messages.add')}}</button>
                    </div>
                </form>
            </div>
        @endforeach
        <div class="links">
            <a href="{{route('cart')}}">{{trans('messages.cart')}}</a>
        </div>
    </div>
</body>

</html>
