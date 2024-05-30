<x-guest-layout>
    <div class="text-center my-8">
        <a href="/">
            <h2 class="font-black">会員登録</h2>
        </a>
    </div>
    <form class="mb-24" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <!-- <x-input-label for="name" :value="__('Name')" /> -->
            <x-text-input id="name" class="block mt-1 mb-8 w-full bg-gray-100 border-black" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="名前" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <!-- <x-input-label for="email" :value="__('Email')" /> -->
            <x-text-input id="email" class="block mt-1 mb-8 w-full bg-gray-100 border-black" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="メールアドレス" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <!-- <x-input-label for="password" :value="__('Password')" /> -->

            <x-text-input id="password" class="block mt-1 mb-8 w-full bg-gray-100 border-black"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="パスワード" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <!-- <x-input-label for="password_confirmation" :value="__('Confirm Password')" /> -->

            <x-text-input id="password_confirmation" class="block mt-1 mb-8 w-full bg-gray-100 border-black"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="確認用パスワード" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-center">
            <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a> -->

            <x-primary-button class="w-full">
                {{ __('会員登録') }}
            </x-primary-button>
            
        </div>

        <div class="flex justify-center">
            <p class="text-center">アカウントをお持ちの方はこちらから<br>
            <a class="underline text-sm text-blue-700 no-underline hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('ログイン') }}
            </a>
            </p>
        </div>
    </form>
</x-guest-layout>
