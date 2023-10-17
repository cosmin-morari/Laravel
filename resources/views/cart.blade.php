@extends('layouts.app')
@section('title', trans('messages.cartPage'))

@section('content')




    <div class="container">
        @if (isset($mail) && !$mail)
            <h1>{{ trans('messages.cartPage') }}</h1>
        @else
            <h1>{{ trans('messages.order') }}</h1>
        @endif
        @if (isset($products))
            @foreach ($products as $product)
                <div class="content">
                    <form action="{{ route('deleteUpdateProductFromCart', [$product->id]) }}" method="POST">
                        @csrf
                        <div class="img">
                            <img src="{{ asset('storage/photos/' . $product->imageSource) }}" alt="">
                        </div>
                        <div class="details">
                            <p>{{ trans('messages.title') }}:{{ $product->title }}</p>
                            <p>{{ trans('messages.description') }}:{{ $product->description }}</p>
                            <p>{{ trans('messages.price') }}:{{ $product->price }}</p>
                            <p>{{ trans('messages.quantity') }}:

                            @foreach ($cartQuantity as $quantity)
                                @if (isset($quantity[$product->id]))
                                    <input type="number" name="quantity" value="{{ $quantity[$product->id] }}">
                                    <input type="submit" name="update" value="{{ trans('messages.update') }}">
                                @endif
                            @endforeach
                            
                        </div>
                        @if (isset($mail) && !$mail)
                            <div>
                                <button type="submit" name ="delete" value="delete" class="RemoveBtn">{{ trans('messages.delete') }}</button>
                            </div>
                        @endif
                    </form>
                </div>
            @endforeach
            @if (isset($mail) && !$mail)
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
            @elseif (isset($mail) && $mail)
                <h3>{{ trans('messages.checkoutInformation') }}</h3>
                <p>{{ trans('messages.name') }} : {{ request('name') }}</p>
                <p>{{ trans('messages.email') }} : {{ request('contactDetails') }}</p>
                <p>{{ trans('messages.comments') }} : {{ request('comments') }}</p>
            @endif
        @elseif (!isset($products) && isset($empty))
            {{ $empty }}
        @endif
        @if (isset($mail) && !$mail)
            <div class="links">
                <a href="{{ route('index') }}">{{ trans('messages.index') }}</a>
            </div>
        @endif
    </div>


@endsection
