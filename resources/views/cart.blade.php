<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>{{ trans('messages.cartPage') }}</title>
</head>

<body>
    <div class="container">
        @if (isset($toAdmin) && !$toAdmin)
            <h1>{{ trans('messages.cartPage') }}</h1>
        @else
            <h1>{{ trans('messages.order') }}</h1>
        @endif
        @if (isset($products))
            @foreach ($products as $product)
                <div class="content">
                    <form action="{{ route('deleteProductFromCart', [$product->id]) }}" method="POST">
                        @csrf
                        <div class="img">
                            <img src="{{ asset('storage/photos/' . $product->imageSource) }}" alt="">
                        </div>
                        <div class="details">
                            <p>{{ trans('messages.title') }}:{{ $product->title }}</p>
                            <p>{{ trans('messages.description') }}:{{ $product->description }}</p>
                            <p>{{ trans('messages.price') }}:{{ $product->price }}</p>
                        </div>
                        @if (isset($toAdmin) && !$toAdmin)
                            <div>
                                <button type="submit" class="RemoveBtn">{{ trans('messages.delete') }}</button>
                            </div>
                        @endif
                    </form>
                </div>
            @endforeach
            @if (isset($toAdmin) && !$toAdmin)
                <form action="{{ route('checkout') }}" class="checkOut" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="{{ trans('messages.name') }}"
                        value="{{ old('name') }}">
                    @error('name')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                    <input type="text" name="contactDetails" placeholder="{{ trans('messages.contactDetails') }}"
                        value="{{ old('contactDetails') }}">
                    @error('contactDetails')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                    <textarea name="comments" placeholder="{{ trans('messages.comments') }}" cols="20" rows="4"> {{ old('comments') }}</textarea>
                    @error('comments')
                        <p style="color:red;">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="RemoveBtn">{{ trans('messages.checkout') }}</button>
                </form>
            @else
                <h3>{{ trans('messages.checkoutInformation') }}</h3>
                <p>{{ trans('messages.name') }} : {{ request('name') }}</p>
                <p>{{ trans('messages.email') }} : {{ request('contactDetails') }}</p>
                <p>{{ trans('messages.comments') }} : {{ request('comments') }}</p>
            @endif
        @elseif (!isset($products) && isset($empty))
            {{ $empty }}
        @endif
        @if (isset($toAdmin) && !$toAdmin)
            <div class="links">
                <a href="{{ route('index') }}">{{ trans('messages.index') }}</a>
            </div>
        @endif
    </div>

</body>

</html>
