@extends('layouts.app')
@section('title', trans('messages.productPage'))



    
@section('content')
 @isset($destination)
     {{ $destination }}
 @endisset


 @isset($product)
 {{ $product }}
@endisset

@endsection