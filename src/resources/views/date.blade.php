<x-app-layout>
    <div class="h-[90%] py-5">
        <div class="text-center">
            <!-- <p>{{ Auth::user()->name }}さんお疲れ様です!</p> -->
        </div>
        
        <div class="flex w-1/2 justify-center mx-auto">
            <form action="/attendance" method="post">
                @csrf
                <input type="submit" class="bg-white text-blue-500 mx-6 px-1 border border-blue-400" name="previous" value="＜">
                    @isset($date)
                        <input type="hidden" name="date" value="{{$date}}">
                        {{$date}}
                    @else
                    <input type="hidden" name="date" value="{{$date}}">
                        {{$date}}
                    @endisset
                <input type="submit" class="bg-white text-blue-500 mx-6 px-1 border border-blue-400" name="next" value="＞">
            </form>
        </div>
        <br>
        <table class="w-3/4 mx-auto">
            <tr class="border-y border-black">
                <th class="py-4">名前</th>
                <th class="py-4">勤務開始</th>
                <th class="py-4">勤務終了</th>
                <th class="py-4">休憩時間</th>
                <th class="py-4">勤務時間</th>
            </tr>
            @foreach($users as $user)
            <tr class="border-b border-black">
                @php
                    //元データ
                    $workStart=strtotime($user->work_start);
                    $strStart = new DateTime($user->work_start);
                    $strStart = $strStart->format('H:i:s');
                    $workEnd=strtotime($user->work_end);
                    if(!empty($workEnd)){
                        $strEnd = new DateTime($user->work_end);
                        $strEnd = $strEnd->format('H:i:s');
                    }else{
                        $strEnd = "";
                    }
                    $intTotalBreakTime=$user->break_total_time;

                    //休憩時間
                    $hour=str_pad(floor($intTotalBreakTime/3600),2,0,STR_PAD_LEFT);
                    $minite=str_pad(floor($intTotalBreakTime%3600/60),2,0,STR_PAD_LEFT);
                    $second=str_pad(floor($intTotalBreakTime%60),2,0,STR_PAD_LEFT);
                    $totalBreakTime=$hour.':'.$minite.':'.$second;

                    //勤務時間
                    if(!(empty($workEnd))){
                        $workTime=($workEnd-$workStart)-$intTotalBreakTime;
                        $hour=str_pad(floor($workTime/3600),2,0,STR_PAD_LEFT);
                        $minite=str_pad(floor($workTime%3600/60),2,0,STR_PAD_LEFT);
                        $second=str_pad(floor($workTime%60),2,0,STR_PAD_LEFT);
                        $workTime=$hour.':'.$minite.':'.$second;
                    }else{
                        $workTime='勤務中';
                    }

                @endphp
                <td class="py-4 text-center w-1/6">{{$user->name}}</td>
                <td class="py-4 text-center w-1/6">{{$strStart}}</td>
                <td class="py-4 text-center w-1/6">{{$strEnd}}</td>
                <td class="py-4 text-center w-1/6">{{$totalBreakTime}}</td>
                <td class="py-4 text-center w-1/6">{{$workTime}}</td>
                <td class="py-4 text-center w-1/6"><a class="px-4 py-2 bg-blue-500 rounded-md text-white" href="#{{$user->user_id}}">詳細</a></td>
            </div>
            </tr>
            <div id="{{$user->user_id}}" class="hidden target:block">
                <div class="block w-full h-full bg-black/70 absolute top-0 left-0">
                    <div class="flex flex-col mx-auto my-32 bg-white w-[40%] h-1/2">
                        <a class="text-right px-4 py-2" href="#">✖︎</a>
                        <form class="py-2" action="/update" method="post">
                            @csrf
                            <input type="hidden" name="name" value="{{$user->user_id}}">
                            <input type="hidden" name="date" value="{{$date}}">
                            <p class="mx-8">勤務開始：</p><input class="w-1/2 mx-auto my-4" type="datetime-local" name="startTime">
                            <p class="mx-8">勤務終了：</p><input class="w-1/2 mx-auto my-4" type="datetime-local" name="endTime">
                            <input class="px-4 py-2 mx-auto my-8 w-1/4 bg-blue-500 rounded-md text-white" type="submit" value="編集">
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </table>
        <div class="my-8">
            {{ $users->links() }}
        </div>
    </div>
    <footer class="h-[10%] bg-white text-center content-center footer__content">Atte,inc.</footer>
</x-app-layout>