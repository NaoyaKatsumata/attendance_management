<x-app-layout>
    <div class="h-[90%] py-5">
        <div class="w-[70%] mx-auto">
            <h1 class="m-4 text-2xl text-center">勤怠時刻修正</h1>
            <div class="w-full flex-col">
                @foreach($attends as $attend)
                <form class="flex" action="/edit" method="post">
                    @csrf
                    <div class="w-full flex border-b border-black" >
                    @php
                        $strTime=$attend->work_start;
                        $strTime = substr($strTime, 0, -3);
                        @endphp
                        <p class="w-[30%] flex items-center px-4 ">勤務開始</p>
                        <input type="hidden" name="flg" value="0">
                        <input type="hidden" name="id" value="{{$attend->user_id}}">
                        <input type="datetime-local" class="w-[50%] px-2 my-2" name="workStart" value="{{$strTime}}">
                        <input type="submit" class="mx-auto my-2 px-4 bg-blue-400 rounded-md text-white" name="" value="更新">
                    </div>
                </form>
                <form class="flex" action="/edit" method="post">
                    @csrf
                    <div class="w-full flex border-b border-black" >
                        
                        <p class="w-[30%] flex items-center px-4 ">勤務終了</p>
                        <input type="hidden" name="flg" value="1">
                        <input type="hidden" name="id" value="{{$attend->user_id}}">
                        <input type="hidden" name="workStart" value="{{$attend->work_start}}">
                        <input type="datetime-local" class="w-[50%] px-2 my-2" name="workEnd" value="{{$attend->work_end}}" step=60>
                        <input type="submit" class="mx-auto my-2 px-4 bg-blue-400 rounded-md text-white" name="" value="更新">
                    </div>
                </form>
                @endforeach
                @foreach($breakTimes as $breakTime)
                <form class="flex" action="/edit" method="post">
                    @csrf
                    <div class="w-full flex border-b border-black" >
                        @php
                        $strTime=$breakTime->start_time;
                        $strTime = substr($strTime, 0, -3);
                        @endphp
                        <p class="w-[30%] flex items-center px-4">休憩開始{{$breakTime->count}}</p>
                        <input type="hidden" name="count" value="{{$breakTime->count}}">
                        <input type="hidden" name="id" value="{{$attend->user_id}}">
                        <input type="hidden" name="flg" value="2">
                        <input type="datetime-local" class="w-[50%] px-2 my-2" name="breakStart" value="{{$strTime}}">
                        <input type="submit" class="mx-auto my-2 px-4 bg-blue-400 rounded-md text-white" name="" value="更新">
                    </div>
                </form>
                <form class="flex" action="/edit" method="post">
                    @csrf
                    <div class="w-full flex border-b border-black" >
                        @php
                        $strTime=$breakTime->end_time;
                        $strTime = substr($strTime, 0, -3);
                        @endphp
                        <p class="w-[30%] flex items-center px-4">休憩終了{{$breakTime->count}}</p>
                        <input type="hidden" name="count" value="{{$breakTime->count}}">
                        <input type="hidden" name="id" value="{{$attend->user_id}}">
                        <input type="hidden" name="flg" value="3">
                        <input type="hidden" name="breakStart" value="{{$breakTime->start_time}}">
                        <input type="datetime-local" class="w-[50%] px-2 my-2" name="breakEnd" value="{{$strTime}}">
                        <input type="submit" class="mx-auto my-2 px-4 bg-blue-400 rounded-md text-white" name="" value="更新">
                    </div>
                </form>
                @endforeach
            </div>
        </div>
    </div>
    <footer class="h-[10%] bg-white flex content-center items-center">
        <p class="mx-auto">Atte,inc.</p>
    </footer>
</x-app-layout>
