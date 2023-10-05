@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center">
    <h1 class="text-xl font-bold mb-4">{{ __('Register') }}</h1>

    <div class="bg-slate-200 p-4 rounded-lg">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="flex flex-row my-2 w-full justify-between">
                <label for="name" class="mr-4">{{ __('Name') }}</label>

                <div class="">
                    <input id="name" type="name" class="@error('name') text-red-700 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
            </div>

            @error('name')
                <span class="block text-red-700" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            
            <div class="flex flex-row my-2 w-full justify-between">
                <label for="email" class="mr-4">{{ __('Email Address') }}</label>

                <div class="">
                    <input id="email" type="email" class="@error('email') text-red-700 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    
                </div>
            </div>
            @error('email')
                <span class="block text-red-700" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="flex flex-row my-2 w-full justify-between">
                <label for="password" class="mr-4">{{ __('Password') }}</label>

                <div class="">
                    <input id="password" type="password" class="@error('password') text-red-700 @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                </div>
            </div>
            @error('password')
                <span class="block text-red-700" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="flex flex-row my-2 w-full justify-between">
                <label for="password-confirm" class="mr-4">{{ __('Confirm Password') }}</label>

                <div class="">
                    <input id="password-confirm" type="password" name="password_confirmation" value="{{ old('password-confirm') }}" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="bg-green-300 p-2 rounded-md">
                {{ __('Register') }}
            </button>
        </form>
    </div>
</div>
@endsection
