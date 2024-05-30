<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attend;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagementController extends Controller
{
    public function view(){
        $id=Auth::user()->id;
        $date = Carbon::now()->toDateString();
        $nextDate=Carbon::now()->addDays(1)->toDateString();
        $status=Attend::where('user_id','=',$id)
        ->orderBy('work_start','desc')->first();
        //  dd($date,$nextDate,$status,$id);
        if(!(isset($status))){
            $status=0;
        }else{
            $status=$status->status;
        }
        return view('stamp',['status'=>$status]);
    }

    public function viewDate(){
        $date = Carbon::now()->toDateString();
        $nextDate=Carbon::now()->addDays(1)->toDateString();
        $users=Attend::whereBetween('work_start',[$date,$nextDate])
        ->join('users','users.id','=','attends.user_id')
        ->Paginate(5);
        
        return view('date',['date'=>$date,'users'=>$users]);
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
                    'status'=>1
                ];
                Attend::create($form);
            }
            return redirect('/');
        }elseif($request->input('finish')=='勤務終了'){
                $form=[
                    'work_end'=>$now,
                    'status'=>0
                ];
                $attend->update($form);
            return redirect('/');
        }elseif($request->input('breakStart')=='休憩開始'){
            $form=[
                'break_time_start'=>$now,
                'status'=>2
            ];
            $attend->update($form);
            return redirect('/');
        }elseif($request->input('breakEnd')=='休憩終了'){
            // dd($attend);
            $breakStart=new Carbon($attend->break_time_start);
            $totalBreakTime=(int)$breakStart->diffInSeconds($now);
            if(!(is_null($attend->break_time_end))){
                $totalBreakTime=(int)$attend->break_total_time + $totalBreakTime;
            }
            $form=[
                'break_time_end'=>$now,
                'break_total_time'=>$totalBreakTime,
                'status'=>3
            ];
            $attend->update($form);
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
        return view('date',compact('date','users'));
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
                    'status'=>1
                ];
                $attend->update($form);
        }
        return redirect('/');
    }

    public function test(Request $request){
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
            $date=new Carbon($startTime);
        }
        if(isset($endTime)){
            $form=$form+array('work_end'=>$endTime);
        }
        if(isset($startTime) or isset($endTime)){
            $form=$form+array('status'=>0);
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
}
