<?php

namespace App\Http\Controllers;

use App\Models\MemberActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MeritBarController extends Controller
{
    // Count Member's Merit Bar records
    public function displayMemberMeritBar($id)
    {

        $activities = MemberActivity::select('*',DB::raw('count(type_of_activityid) as cnt'),DB::raw('sum(no_of_hour) as total_hours'),DB::raw('sum(point) as total_points'),DB::raw('sum(mile) as total_miles'))->where('memberid',$id)->groupBy('type_of_activityid')->get();
        $activityArr = [];

        if($activities->count() > 0)
        {
            foreach($activities as $activity)
            {
                $award1 = ""; $award2 = ""; $award3 = ""; $award4 = ""; $award5 = "";

                $type_of_activityid = $activity['type_of_activityid'];

                if($type_of_activityid == 1 || $type_of_activityid == 9){
                    if($activity->cnt >= 6)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 12)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 18)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 24)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 30)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 2){
                    if($activity->cnt == 0)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt == 0)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt == 0)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt == 0)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >=30)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 4 || $type_of_activityid == 10 || $type_of_activityid == 13){
                    if($activity->cnt >= 3)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 6)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 9)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 12)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 18)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 5 || $type_of_activityid == 17 || $type_of_activityid == 18){
                    if($activity->cnt >= 1)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 2)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 3)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 4)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 5)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 6){
                    if($activity->cnt >= 2)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 4)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 6)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 8)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 10)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 8){
                    if($activity->cnt >= 3)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 6)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 9)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 12)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 15)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 14){
                    if($activity->cnt >= 4)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 8)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 12)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 16)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 20)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 15){
                    if($activity->cnt == 0)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt == 0)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt == 0)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt == 0)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 30)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($type_of_activityid == 17){
                    if($activity->cnt >= 1)
                    {
                        $award1 = "Eligible";
                    }
                    if($activity->cnt >= 0)
                    {
                        $award2 = "Eligible";
                    }
                    if($activity->cnt >= 0)
                    {
                        $award3 = "Eligible";
                    }
                    if($activity->cnt >= 0)
                    {
                        $award4 = "Eligible";
                    }
                    if($activity->cnt >= 30)
                    {
                        $award5 = "Eligible";
                    }
                }elseif($activities->sum('total_hours') > 0){
                    if($type_of_activityid == 3 || $type_of_activityid == 11){
                        if($activity->total_hours >= 10)
                        {
                            $award1 = "Eligible";
                        }
                        if($activity->total_hours >= 20)
                        {
                            $award2 = "Eligible";
                        }
                        if($activity->total_hours >= 30)
                        {
                            $award3 = "Eligible";
                        }
                        if($activity->total_hours >= 40)
                        {
                            $award4 = "Eligible";
                        }
                        if($activity->total_hours >= 50)
                        {
                            $award5 = "Eligible";
                        }
                    }elseif($type_of_activityid == 7 || $type_of_activityid == 12){
                        if($activity->total_hours >= 20)
                        {
                            $award1 = "Eligible";
                        }
                        if($activity->total_hours >= 40)
                        {
                            $award2 = "Eligible";
                        }
                        if($activity->total_hours >= 60)
                        {
                            $award3 = "Eligible";
                        }
                        if($activity->total_hours >= 80)
                        {
                            $award4 = "Eligible";
                        }
                        if($activity->total_hours >= 100)
                        {
                            $award5 = "Eligible";
                        }
                    }elseif($activities->sum('total_points') > 0){
                        if($type_of_activityid == 16){
                            if($activity->total_points >= 125)
                            {
                                $award1 = "Eligible";
                            }
                            if($activity->total_points >= 250)
                            {
                                $award2 = "Eligible";
                            }
                            if($activity->total_points >= 375)
                            {
                                $award3 = "Eligible";
                            }
                            if($activity->total_points >= 500)
                            {
                                $award4 = "Eligible";
                            }
                            if($activity->total_points >= 625)
                            {
                                $award5 = "Eligible";
                            }
                        }elseif($activities->sum('total_miles') > 0){
                            if($type_of_activityid == 19){
                                if($activity->total_miles >= 150)
                                {
                                    $award1 = "Eligible";
                                }
                                if($activity->total_miles >= 300)
                                {
                                    $award2 = "Eligible";
                                }
                                if($activity->total_miles >= 450)
                                {
                                    $award3 = "Eligible";
                                }
                                if($activity->total_miles >= 600)
                                {
                                    $award4 = "Eligible";
                                }
                                if($activity->total_miles >= 750)
                                {
                                    $award5 = "Eligible";
                                }
                            }
                        }
                    }
                }   

                $activityArr[$activity->activity->activity] = [
                    'award1' => $award1,
                    'award2' => $award2,
                    'award3' => $award3,
                    'award4' => $award4,
                    'award5' => $award5,
                ];
                
            }
        }

        return view('merit-bar-record', compact('activityArr'));
    }

}
