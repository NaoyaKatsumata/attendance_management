<x-app-layout>
    <div class="h-[90%] py-5">
        <div class="text-center">
            <!-- <p>{{ Auth::user()->name }}さんお疲れ様です!</p> -->
        </div>
        
        <div class="w-[50%] mx-auto">
            <div class="text-center">
                <p>すでに勤務開始されています。<br>
                勤務開始時間を現在の時刻に上書きしますか？</p>
            </div>
            <form class="w-[50%] mx-auto my-8 flex justify-between" action="/confirm" method="post">
                @csrf
                <input type="submit" name="confirm_Y" value="YES">
                <input type="submit" name="confirm_N" value="NO">
                <input type="hidden" name="userId" value="{{$users->user_id}}">
            </form>
        </div>
    </div>
    <footer class="h-[10%] bg-white text-center content-center footer__content">Atte,inc.</footer>
</x-app-layout>