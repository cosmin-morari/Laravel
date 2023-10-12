@include('layouts.header')
<title>{{ trans('messages.productsPage') }}</title>

<body>

    <form action= "{{route('logoutAdmin')}}" method="POST">
        @csrf
    <input type="submit" class="logout" name="logout" value="{{trans('messages.logout')}}">
    </form>
    @include('layouts.footer')

