<x-app-layout>
    <div class="h-[90%] py-5">
        <div class="text-center">
            <p>{{ Auth::user()->name }}さんお疲れ様です!</p>
        </div>
        <div class="flex-col w-3/4 justify-center mx-auto">
            <form action="/store" method="POST">
                @csrf
                <div class="flex justify-center my-10">
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    @if($status==0)
                        <input class="bg-white mx-5 py-12 px-28" type="submit" name="attendance" value="勤務開始">
                        <input class="bg-gray-200 text-slate-500 mx-5 py-12 px-28" type="submit" name="finish" value="勤務終了" disabled>
                    @else
                        <input class="bg-gray-200 text-slate-500 mx-5 py-12 px-28" type="submit" name="attendance" value="勤務開始" disabled>
                        <input class="bg-white mx-5 py-12 px-28" type="submit" name="finish" value="勤務終了" >
                    @endif
                </div>
                <div class="flex justify-center my-10">
                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                    @if($status==0)
                        <input class="bg-gray-200 text-slate-500 mx-5 py-12 px-28" type="submit" name="breakStart" value="休憩開始">
                        <input class="bg-gray-200 text-slate-500 mx-5 py-12 px-28" type="submit" name="breakEnd" value="休憩終了">
                    @elseif($status==2)
                    <input class="bg-gray-200 text-slate-500 mx-5 py-12 px-28" type="submit" name="breakStart" value="休憩開始" disabled>
                        <input class="bg-white mx-5 py-12 px-28" type="submit" name="breakEnd" value="休憩終了">

                    @elseif($status==1 or $status==3)
                        <input class="bg-white mx-5 py-12 px-28" type="submit" name="breakStart" value="休憩開始">
                        <input class="bg-gray-200 text-slate-500 mx-5 py-12 px-28" type="submit" name="breakEnd" value="休憩終了" disabled>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <footer class="h-[10%] bg-white text-center content-center footer__content">Atte,inc.</footer>
</x-app-layout>