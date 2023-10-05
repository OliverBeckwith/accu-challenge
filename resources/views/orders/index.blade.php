@extends('layouts.app')

@section('title','Orders')

@section('body')
<div class="h-screen w-screen p-8">
    <div class="flex flex-col h-full px-8 py-2 border-8 box-border bg-slate-300 rounded-lg">
        <h1 class="text-xl text-center my-2">List of Orders</h1>
        <ul class='overflow-y-auto' >
            @foreach($orders as $order)
            <a href="/order/{{$order->id}}">
                <li class="flex flex-col py-1 px-2 my-1 border-2 rounded-md border-slate-400 bg-slate-200 cursor-pointer hover:border-slate-700 hover:bg-slate-50">
                    <strong class="">Order #{{ $order->id }}</strong>
                    <span>Customer: {{ $order->customer_name }}</span>
                    <span>Bot: {{ $order->getBotName() }}</span>
                </li>
            </a>
            @endforeach
        </ul>
    </div>
</div>
@endsection