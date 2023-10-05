@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center">
    <h1 class="text-xl font-bold mb-4">{{ __('Login') }}</h1>

    <div class="bg-slate-200 p-4 rounded-lg">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="flex flex-row my-2 w-full justify-between">
                <label for="email" class="mr-4">{{ __('Email Address') }}</label>

                <div class="">
                    <input id="email" type="email" class="@error('email') text-red-700 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="flex flex-row my-2 w-full justify-between">
                <label for="password" class="mr-4">{{ __('Password') }}</label>

                <div class="">
                    <input id="password" type="password" class="@error('password') text-red-700 @enderror" name="password" value="{{ old('password') }}" required autocomplete="current-password">

                    @error('password')
                        <span role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="flex flex-row my-2 w-full">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="ml-2" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>

            <div class="flex flex-row my-2 w-full justify-between">
                <button type="submit" class="bg-green-300 p-2 rounded-md">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="bg-orange-300 p-2 rounded-md" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
