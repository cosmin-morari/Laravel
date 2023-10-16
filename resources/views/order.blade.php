@extends('layouts.app')
@section('title', trans('messages.order'))


@section('content')

    <div class="content">
        <h1>{{ trans('messages.order') }}</h1>
        <table style="text-align: center;" border="1">
            <thead>
                <tr>
                    <th>{{ trans('messages.id') }}</th>
                    <th>{{ trans('messages.date') }}</th>
                    <th>{{ trans('messages.name') }}</th>
                    <th>{{ trans('messages.contactDetails') }}</th>
                    <th>{{ trans('messages.comments') }}</th>
                    <th>{{ trans('messages.purchasedProducts') }}</th>
                </tr>
                
            </thead>
            <tbody>
                <td>{{ $order->id }}</td>
                <td>{{ $order->date }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->contactDetails	}}</td>
                <td>{{ $order->comments	}}</td>
                <td>{{$products}}</td>
            </tbody>
        </table>
        <a href="{{ route('orders') }}">{{ trans('messages.ordersPage') }}</a>
    </div>

@endsection
