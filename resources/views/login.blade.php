<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>{{ trans('messages.login') }}</title>
</head>

<body>
    <form action="{{ route('validateLogin') }}" method="POST">
        @csrf
        <div class="container">
            <h3>{{ trans('messages.login') }}</h3>
            <input type="email" name="adminMail" placeholder="{{ trans('messages.userName') }}"
                value="{{ old('adminMail') }}">
            @error('adminMail')
                <p style="color:red;">{{ $message }}</p>
            @enderror
            <br><br>
            <input type="password" name="adminPassword" placeholder="{{ trans('messages.password') }}"
                value="{{ old('adminPassword') }}">
            @error('adminPassword')
                <p style="color:red;">{{ $message }}</p>
            @enderror
            <br><br>
            <button type="submit">{{ trans('messages.login') }}</button>
        </div>
    </form>
</body>

</html>
