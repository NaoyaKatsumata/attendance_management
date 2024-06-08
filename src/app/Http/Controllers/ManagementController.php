<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attend;
use App\Models\User;
use App\Models\BreakTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagementController extends Controller
{
    public function view(){
        $id=Auth::user()->id;
        $date = Carbon::now()->toDateString();
        $nextDate=Carbon::now()->addDays(1)->toDateString();
        $workStartStatus=Attend::select('work_start')
        ->where([['user_id','=',$id],['work_start','<>',null],['work_start','>',$date],['work_start','<',$nextDate]])
        ->get()
        ->toArray();
        $workEndStatus=Attend::select('work_end')
        ->where([['user_id','=',$id],['work_end','<>',null],['work_start','>',$date],['work_start','<',$nextDate]])
        ->get()
        ->toArray();
        $breakStatus=BreakTime::where([['user_id','=',$id],['start_time','>',$date],['start_time','<',$nextDate]])
        ->orderBy('count','desc')
        ->first();
        $workStartCount=count($workStartStatus);
        $workEndCount=count($workEndStatus);
        // dd($workStartCount,$workEndCount,$breakStatus);
        return view('stamp',compact('workStartCount','workEndCount','breakStatus'));
    }

    public function viewDate(){
        $date = Carbon::now()->toDateString();
        $nextDate=Carbon::now()->addDays(1)->toDateString();
        $users=Attend::whereBetween('work_start',[$date,$nextDate])
        ->join('users','users.id','=','attends.user_id')
        ->Paginate(5);
        $breakTimes=BreakTime::whereBetween('start_time',[$date,$nextDate])
        ->orderBy('count')
        ->get();
        // dd($users,$breakTimes);
        return view('date',['date'=>$date,'users'=>$users,'breakTimes'=>$breakTimes]);
    }


    public function store(Request $request){
        $date = Carbon::now()->toDateString();
        $nextDate=Carbon::now()->addDays(1)->toDateString();
        $now=Carbon::now();
        $userId=User::where('name','=',$request->name)->first();
        $attend=Attend::where('user_id','=',$userId->id)
        ->orderBy('work_start','desc')
        ->first();
        if($request->input('attendance')=='勤務開始'){
            $attend=Attend::where('user_id','=',$userId->id)
            ->whereBetween('work_start',[$date,$nextDate])
            ->first();
            if(!(is_null($attend))){
                return view('confirm',['users'=>$attend]);
            }else{
                $form=[
                    'user_id'=>$userId->id,
                    'work_start'=> $now,
                    'created_at'=>$now,
                    'updated_at'=>$now
                ];
                Attend::create($form);
            }
            return redirect('/');
        }elseif($request->input('finish')=='勤務終了'){
                $form=[
                    'work_end'=>$now,
                    'updated_at'=>$now
                ];
                $attend->update($form);
            return redirect('/');
        }elseif($request->input('breakStart')=='休憩開始'){
            // $maxCount=BreakTime::where([['user_id','=',$userId],['input_time','<',$nextDate],['input_time','>',$date],['mode','=',0]])->get();
            $maxCount=BreakTime::where('user_id','=',$userId->id)
            ->whereBetween('start_time',[$date,$nextDate])
            ->max('count');
            // dd($nextDate,$date,$userId,$maxCount);
            if(is_null($maxCount)){
                $maxCount=1;
            }else{
                $maxCount = $maxCount + 1;
            }
            // dd($maxCount);
            $form=[
                'user_id'=>$userId->id,
                'count'=>$maxCount,
                'start_time'=>$now,
            ];
            BreakTime::create($form);
            return redirect('/');
        }elseif($request->input('breakEnd')=='休憩終了'){
            $maxCount=BreakTime::where('user_id','=',$userId->id)
            ->whereBetween('start_time',[$date,$nextDate])
            ->max('count');
            if(is_null($maxCount)){
                $maxCount=1;
            }
            $user=BreakTime::where('user_id','=',$userId->id)
            ->where('count','=',$maxCount)
            ->whereBetween('start_time',[$date,$nextDate])
            ->first();
            $form=[
                'end_time'=>$now,
            ];
            // BreakTime::create($form);
            $user->update($form);
            return redirect('/');
        };
    }

    public function search(Request $request){
        $requestDate=$request->date;
        if($request->input('previous')=='＜'){
            $date=new Carbon($requestDate);
            $date->addDays(-1)->toDateString();
        }elseif($request->input('next')=='＞'){
            $date=new Carbon($requestDate);
            $date->addDays(+1)->toDateString();
        }
        $nextDate=new Carbon($date);
        $nextDate->addDays(1)->toDateString();
        $users=Attend::whereBetween('work_start',[$date,$nextDate])
        ->join('users','users.id','=','attends.user_id')
        ->Paginate(5);
        $date=$date->isoFormat('YYYY-M-D');
        $breakTimes=BreakTime::whereBetween('start_time',[$date,$nextDate])
        ->orderBy('count')
        ->get();
        // dd($breakTime);
        return view('date',['date'=>$date,'users'=>$users,'breakTimes'=>$breakTimes]);
    }

    public function confirm(Request $request){
        $date = Carbon::now()->toDateString();
        $nextDate=Carbon::now()->addDays(1)->toDateString();
        $now=Carbon::now();
        $userId=User::where('name','=',$request->name)->first();
        $attend=Attend::where('user_id','=',$request->userId)
        ->whereBetween('work_start',[$date,$nextDate])
        ->first();
        if($request->input('confirm_Y')=='YES'){
            $form=[
                    'work_start'=> $now,
                    'work_end'=>null,
                    'status'=>1,
                    'updated_at'=>$now
                ];
                $attend->update($form);
        }
        return redirect('/');
    }

    public function update(Request $request){
        $name=$request->name;
        $attend=Attend::where('user_id','=',$name)
        ->orderBy('work_start','desc')
        ->first();
        $form=[];
        $startTime=$request->startTime;
        $endTime=$request->endTime;
        $date=Carbon::now();
        if(isset($startTime)){
            $form=$form+array('work_start'=>$startTime);
            // $date=new Carbon($startTime);
        }
        if(isset($endTime)){
            $form=$form+array('work_end'=>$endTime);
        }
        if(isset($startTime) or isset($endTime)){
            $form=$form+array('status'=>0);
            $form=$form+array('updated_at'=>$date);
        }
        if(!(is_null($form))){
            $attend->update($form);
        }
        $date=$date->isoFormat('YYYY-M-D');
        $nextDate=new Carbon($date);
        $nextDate->addDays(+1)->toDateString();
        $users=Attend::whereBetween('work_start',[$date,$nextDate])
        ->join('users','users.id','=','attends.user_id')
        ->Paginate(5);
        // dd($date,$nextDate,$users);
        return view('date',compact('date','users'));
    }

    public function editform(Request $request){
        $id=$request->userId;
        $date=$request->date;
        $date=new Carbon($date);
        $nextDate=new Carbon($date);
        $nextDate->addDays(1)->toDateString();
        $attends=Attend::where('user_id','=',$id)
        ->whereBetween('work_start',[$date,$nextDate])
        ->get();
        $breakTimes=BreakTime::whereBetween('start_time',[$date,$nextDate])
        ->where('user_id','=',$id)
        ->orderBy('count')
        ->get();
        // dd($attends,$breakTimes,$date,$nextDate,$request);
        return view('editform',['id'=>$id,'attends'=>$attends,'breakTimes'=>$breakTimes,'date'=>$date,'nextDate'=>$nextDate]);
    }

    public function edit(Request $request){
        if($request->flg<=1){
            $workStart=$request->workStart;
            $id=$request->id;
            $date=new Carbon($workStart);
            $strDate=$date->toDateString();
            $nextDate=new Carbon($date);
            $nextDate->addDays(+1)->toDateString();
            $now=Carbon::now();
            $attend=Attend::where('user_id','=',$id)
            ->whereBetween('work_start',[$strDate,$nextDate])
            ->first();
            if($request->flg==0){
                $form=[
                    'work_start'=> $workStart,
                    'updated_at'=>$now
                ];
                $attend->update($form);
            }else{
                $form=[
                    'work_end'=> $request->workEnd,
                    'updated_at'=>$now
                ];
                $attend->update($form);
            }
            $date=$date->isoFormat('YYYY-M-D');
        }else{
            $breakStart=$request->breakStart;
            $id=$request->id;
            $date=new Carbon($breakStart);
            $strDate=$date->toDateString();
            $nextDate=new Carbon($date);
            $nextDate->addDays(+1)->toDateString();
            $now=Carbon::now();
            $breakTime=BreakTime::where('user_id','=',$id)
            ->where('count','=',$request->count)
            ->whereBetween('start_time',[$strDate,$nextDate])
            ->first();
            if($request->flg==2){
                $form=[
                    'start_time'=> $breakStart,
                    'updated_at'=>$now
                ];
                $breakTime->update($form);
            }else{
                $form=[
                    'end_time'=> $request->breakEnd,
                    'updated_at'=>$now
                ];
                $breakTime->update($form);
            }
            $date=$date->isoFormat('YYYY-M-D');
        }
        $users=Attend::whereBetween('work_start',[$strDate,$nextDate])
        ->join('users','users.id','=','attends.user_id')
        ->Paginate(5);
        
        $breakTimes=BreakTime::whereBetween('start_time',[$strDate,$nextDate])
        ->orderBy('count')
        ->get();
        return view('date',['date'=>$date,'users'=>$users,'breakTimes'=>$breakTimes]);//
    }
}
