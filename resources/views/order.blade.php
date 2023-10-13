@extends('layouts.app')
@section('title', trans('messages.order'))


@section('content')

    <div class="content">
        <h1>{{ trans('messages.order') }}</h1>
        <table style="text-align: center;" border="1">
            <thead>
                <tr>
                    <th>{{ trans('messages.id') }}</th>
                    <th>{{ trans('messages.checkoutInformation') }}</th>
                    <th>{{ trans('messages.purchasedProducts') }}</th>
                </tr>
                
            </thead>
            <tbody>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_details }}</td>
                <td>{{ $order->purchased_products	 }}</td>
            </tbody>
        </table>
        <a href="{{ route('orders') }}">{{ trans('messages.ordersPage') }}</a>
    </div>

@endsection
