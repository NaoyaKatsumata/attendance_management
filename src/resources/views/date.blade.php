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
                <th class="py-4"></th>
            </tr>
            @foreach($users as $user)
            <tr class="border-b border-black">
                @php
                    $id=$user->user_id;
                    $name=$user->name;
                    $start=$user->work_start;
                    $start=strtotime($start);
                    $start=date("H:i:s",$start);
                    $end=$user->work_end;
                    $end=strtotime($end);
                    $end=date("H:i:s",$end);
                    $workTime=strtotime($end)-strtotime($start);
                    $diffTime=0;
                    $arr_start=[];
                    $arr_end=[];
                    foreach($breakTimes as $breakTime){
                        if($id==$breakTime->user_id){
                            //休憩時間
                            $startTime=strtotime("$breakTime->start_time");
                            $endTime=strtotime("$breakTime->end_time");
                            $diffTime=$diffTime+($endTime-$startTime);
                            $hour=str_pad(floor($diffTime/3600),2,0,STR_PAD_LEFT);
                            $minite=str_pad(floor($diffTime%3600/60),2,0,STR_PAD_LEFT);
                            $second=str_pad(floor($diffTime%60),2,0,STR_PAD_LEFT);
                            $totalBreakTime=$hour.':'.$minite.':'.$second;
                            $arrStart[$breakTime->count]=$breakTime->start_time;
                        }
                    }
                    $arrStartCount=count($arrStart);
                    $totalWorkTime=$workTime-$diffTime;
                    $hour=str_pad(floor($totalWorkTime/3600),2,0,STR_PAD_LEFT);
                    $minite=str_pad(floor($totalWorkTime%3600/60),2,0,STR_PAD_LEFT);
                    $second=str_pad(floor($totalWorkTime%60),2,0,STR_PAD_LEFT);
                    $totalWorkTime=$hour.':'.$minite.':'.$second;
                @endphp
                <td class="py-4 text-center w-1/6">{{$name}}</td>
                <td class="py-4 text-center w-1/6">{{$start}}</td>
                <td class="py-4 text-center w-1/6">{{$end}}</td>
                <td class="py-4 text-center w-1/6">{{$totalBreakTime}}</td>
                <td class="py-4 text-center w-1/6">{{$totalWorkTime}}</td>
                <td class="py-4 text-center w-1/6">
                    <form action="/editform" method="post">
                        @csrf
                        <input type="text" class="hidden" name="userId" value="{{$id}}">
                        <input type="text" class="hidden" name="date" value="{{$date}}">
                        <input type="submit" class="px-4 py-2 bg-blue-500 rounded-md text-white" value="詳細">
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="my-8">
            {{ $users->links() }}
        </div>
    </div>
    <footer class="h-[10%] bg-white flex content-center items-center">
        <p class="mx-auto">Atte,inc.</p>
    </footer>
</x-app-layout>