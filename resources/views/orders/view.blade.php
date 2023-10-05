@extends('layouts.app')

@section('title','Order {{$order->id}}')

@section('body')
<div class="h-screen w-screen p-8">
    <div class="relative flex flex-col h-full px-8 py-2 border-8 box-border bg-slate-300 rounded-lg">
        <a class="absolute top-2 left-2 p-1 border-2 rounded-md border-slate-400 bg-slate-200 cursor-pointer hover:border-slate-700 hover:bg-slate-50" href="/orders">Back</a>
        <h1 class="text-xl text-center my-2">Order {{$order->id}}</h1>
        <div class="flex flex-col py-1 px-2 my-1 border-2 rounded-md border-slate-400 bg-slate-200 hover:border-slate-700 hover:bg-slate-50">
            <strong class="">Order #{{ $order->id }}</strong>
            <form method="POST">
              @csrf
              @method('PUT')
              <span>Customer: {{ $order->customer_name }}</span>
              <label class="block" for="bot_name">Bot Name: <input class="border-2 rounded-md border-slate-500" name="bot_name" value="{{$order->getBotName()}}" /></label>
              <span>Order Weight: {{ $order->getTotalWeight() }}</span>
            </form>

            <h2>Items</h2>
            <table>
              <tr>
                <th class="text-left" width="20%">Product SKU</th>
                <th class="text-left" width="50%">Product</th>
                <th class="text-right" width="10%">Quantity</th>
                <th class="text-right" width="20%">Weight</th>
              </tr>
              @foreach($order->orderItems as $item)
              <tr>
                <td class="text-left">{{$item->product_sku}}</td>
                <td class="text-left">{{$item->product->name}}</td>
                <td class="text-right">{{$item->quantity}}</td>
                <td class="text-right">{{$item->product->weight * $item->quantity}} ({{$item->product->weight}} each)</td>
              </tr>
              @endforeach
            </table>
        </div>
    </div>
</div>
@endsection