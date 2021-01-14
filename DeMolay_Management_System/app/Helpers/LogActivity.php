<?php 
namespace App\Helpers;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\Request;
use Request;

class LogActivity 
{   
    /*
        logs an activity 
        params: 
            $activity -> message about activity 
            $action -> specify Create, Update, Delete 
            $member -> optional member id if member affacted
    */
    public static function log($action, $message, $memberid = null )
    {
        $activityLog = new ActivityLog();  
        $activityLog->activity = $message; 
        $activityLog->action = $action;  
        $activityLog->affected_member_id = $memberid;
        $activityLog->url = Request::fullUrl(); 
        $activityLog->user_id = Auth::user()->id; 
        $activityLog->user_first_name = Auth::user()->first_name; 
        $activityLog->user_last_name = Auth::user()->last_name; 
        $activityLog->save();

    } 
    

    public static function displayLog()
    {
        return ActivityLog::latest()->get();
    }
}