@extends('layouts.app')

@section('title','Order {{$order->id}}')

@section('body')
<div class="h-screen w-screen p-8">
    <div class="relative flex flex-col h-full px-8 py-2 border-8 box-border bg-slate-300 rounded-lg">
        <a class="absolute top-2 left-2 p-1 border-2 rounded-md border-slate-400 bg-slate-200 cursor-pointer hover:border-slate-700 hover:bg-slate-50" href="/orders">Back</a>
        <h1 class="text-xl text-center my-2">Order {{$order->id}}</h1>
        <div class="flex flex-col py-1 px-2 my-1 border-2 rounded-md border-slate-400 bg-slate-200 hover:border-slate-700 hover:bg-slate-50">
            <strong class="">Order #{{ $order->id }}</strong>
            <span>Customer: {{ $order->customer_name }}</span>
            <span>Bot Name: {{ $order->getBotName() }}</span>
            <span>Order Weight: {{ $order->getTotalWeight() }}</span>

            <h2>Items</h2>
            <table>
              <tr>
                <th width="20%">Product SKU</th>
                <th width="50%">Product</th>
                <th width="10%">Quantity</th>
                <th width="20%">Weight</th>
              </tr>
              @foreach($order->orderItems as $item)
              <tr>
                <td>{{$item->product_sku}}</td>
                <td>{{$item->product->name}}</td>
                <td class="text-right">{{$item->quantity}}</td>
                <td class="text-right">{{$item->product->weight * $item->quantity}} ({{$item->product->weight}} each)</td>
              </tr>
              @endforeach
            </table>
        </div>
    </div>
</div>
@endsection