<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> -->
    <div class="py-5">
        @if(isset($status)){
            $status=0;
        }
        @endif
        <div class="text-center">
            <p>{{ Auth::user()->name }}さんお疲れ様です!</p>
            <h1>{{$status}}</h1>
        </div>
        <div class="flex-col w-3/4 justify-center mx-auto">
            <div class="flex justify-center my-10">
                <form action="/store" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input class="bg-white mx-5 py-12 px-28" type="submit" name="attendance" value="勤務開始">
                    <input class="bg-white mx-5 py-12 px-28" type="submit" name="finish" value="勤務終了">
                </form>
            </div>
            <div class="flex justify-center my-10">
                <form action="/store" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    <input class="bg-white mx-5 py-12 px-28" type="submit" name="breakStart" value="休憩開始">
                    <input class="bg-white mx-5 py-12 px-28" type="submit" name="breakEnd" value="休憩終了">
                </form>
            </div>
        </div>
        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                {{ Auth::user()->name }}
                </div>
            </div>
        </div> -->
    </div>
</x-app-layout>
