<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
//use App\Models\ActivityLog;
use App\Models\MeritBar;
use App\Models\TypeOfActivity;
use App\Models\Member;
use App\Models\MemberActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\MeritBarRecord;

class MeritBarRecordController extends Controller
{
    // 

    public function loadPage($id)
    {
       $meritBars =  DB::table('merit_bars')->get();  
       $records = DB::table('merit_bar_records')
       ->join('merit_bars', 'merit_bar_records.merit_bar_id', '=', 'merit_bars.id')
       ->join('activity_categories', 'merit_bar_records.activity_id', '=', 'activity_categories.id') 
       ->where('member_id', $id)
       ->get(); 

        return view('member.merit-bar-record', ['records'=>$records, 'meritbars'=>$meritBars, 'id'=>$id]);
    }

    public function addRecordPage($id)
    {
        $meritBars =  DB::table('merit_bars')->get();  
        $activity = DB::table('activity_categories')->get();  

        return view('member.add-meritbar', ['meritBar'=>$meritBars, 'activities'=>$activity, 'id'=>$id]);
    } 

    public function addMeritBar(Request $req) 
    {   
        $date = Carbon::now(); 
        //print($date); 
       //$date = $date->addDays(1);  

       $value = DB::table('merit_bar_records')->where('member_id', $req->id)->where('activity_id', $req->activity)->max('merit_bar_id'); 
       $name = DB::table('merit_bars')->where('id', $value + 1)->pluck('description')->first();   
       print($value);
       if($value >= $req->meritBar)
       {
           return back()->withInput()->with('error', 'This member already has achieved this merit bar. The next available merit bar for this activity is '.$name);
       }  
       else if($req->meritBar > $value + 1) 
       {
        return back()->withInput()->with('error', 'This member has  not achieved the previous merit bar. The next available merit bar for this activity is '.$name);
       }
       else if(Carbon::parse($req->date_achieved)->gte($date) > 0)
       {
        return back()->withInput()->with('error', 'Cannot add a merit bar that was achieved in the future. Please select the current date.');
       } 
       else
       {
        $meritBar = new MeritBarRecord(); 
        $meritBar->member_id = $req->id; 
        $meritBar->activity_id = $req->activity; 
        $meritBar->merit_bar_id = $req->meritBar; 
        $meritBar->date_achieved = $req->date_achieved; 

        $meritBar->save();
        
        $member = Member::find($req->id);
        $activity = TypeOfActivity::find($req->activity); 
        $merit = MeritBar::find($req->meritBar);

        LogActivity::log('Create', "Create merit bar $merit->description on $member->first_name $member->last_name for activity $activity->activity", $member->id);

       
        $meritBar->save();  
        return back()->with('success', 'Merit bar successfully added');
       }

        

    }  

    public function recordCalculatedMeritBar($memberid, $type_of_activityid, $meritbarid)
    {   
        $activityCount = MemberActivity::where('memberid', $memberid)->where('type_of_activityid', $type_of_activityid)->max('activityid'); 
        $activity = MemberActivity::where('memberid', $memberid)->where('type_of_activityid', $type_of_activityid)->where('activityid', $activityCount)->first(); 
       
        $value = DB::table('merit_bar_records')->where('member_id', $memberid)->where('activity_id', $type_of_activityid)->max('merit_bar_id'); 
       $name = DB::table('merit_bars')->where('id', $value + 1)->pluck('description')->first();   
       print($value);
       if($value >= $meritbarid)
       {
           return back()->withInput()->with('error', 'This member already has achieved this merit bar. The next available merit bar for this activity is '.$name);
       }  
       else if($meritbarid > $value + 1) 
       {
        return back()->withInput()->with('error', 'This member has  not achieved the previous merit bar. The next available merit bar for this activity is '.$name);
       } 
       else{

        $meritBar = new MeritBarRecord(); 
        $meritBar->member_id = $memberid; 
        $meritBar->activity_id = $type_of_activityid; 
        $meritBar->merit_bar_id = $meritbarid;  
        if($activity != null)
        {
            print('activity');
            $meritBar->date_achieved = $activity->date; 
        }
        else
        {   
            print('now');
            $meritBar->date_achieved = Carbon::now(); 
        }
        $meritBar->save();  
    }
        return back()->with('success', 'Merit bar successfully added');

    }

    public function deleteMeritBarRecord($member_id, $activity_id, $merit_bar_id)
    {   
        print('name');
        //$value = DB::table('merit_bar_records')->where('id', $id)->first(); 
        $value = MeritBarRecord::where('member_id', $member_id)->where('activity_id', $activity_id)->where('merit_bar_id', $merit_bar_id)->first();
        $value == null?print(null):print($value);

        $maxvalue = DB::table('merit_bar_records')->where('member_id', $member_id)->where('activity_id', $activity_id)->max('merit_bar_id'); 

        if($maxvalue > $value->merit_bar_id)
        {
            return back()->with('error', 'Cannot delete this merit bar because a merit bar of a higher level exists. Please delete that merit bar first.'); 
        } 
        else
        {   
            $member = Member::find($member_id);
            $activity = TypeOfActivity::find($activity_id); 
            $merit = MeritBar::find($merit_bar_id); 

            LogActivity::log('Delete', "Delete merit bar $merit->description on $member->first_name $member->last_name for activity $activity->activity", $member_id);
            DB::table('merit_bar_records')->where('member_id', $member_id)->where('activity_id', $activity_id)->where('merit_bar_id', $merit_bar_id)->delete(); 
            
        } 
        return back()->with('success', 'Merit bar successfully deleted');
    }
}
