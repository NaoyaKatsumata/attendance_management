<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="text-center my-8">
        <a href="/">
            <h2 class="font-black">ログイン</h2>
        </a>
    </div>
    <form class="mb-24" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <!-- <x-input-label for="email" :value="__('Email')" /> -->
            <x-text-input id="email" class="block mt-1 mb-8 w-full bg-gray-100 border-black" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="メールアドレス"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <!-- <x-input-label for="password" :value="__('Password')" /> -->

            <x-text-input id="password" class="block mt-1 mb-8 w-full bg-gray-100 border-black"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="パスワード"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <!-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div> -->

        <div class="flex justify-center">
            <x-primary-button class="w-full">
                {{ __('ログイン') }}
            </x-primary-button>
        </div>
        <div class="flex justify-center">
            <p class="text-center">アカウントをお持ちでない方はこちらから<br>
            <a class="underline text-sm text-blue-700 no-underline hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                {{ __('会員登録') }}
            </a>
            </p>
        </div>
    </form>
</x-guest-layout>
