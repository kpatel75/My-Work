<?php

namespace App\Http\Controllers;

use App\Models\MemberActivity;
use App\Models\TypeOfActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogActivity;

class MemberActivityController extends Controller
{
    public function listOfMembers(){
        $members = DB::table('members')->paginate(15);
        return view('member-list', ['members' => $members]);
    }

    public function getMemberInfo($id){
        $details = DB::table('members')->Where('memberid', $id)->get()->first();
        return view('details', ['details' => $details]);
    }

    public function displayMemberActivity($id)
    {
        $activityInfo = DB::table('member_activities')
                ->select('member_activities.advisorid','member_activities.type_of_activityid','activity_categories.activity','member_activities.note','users.first_name','users.last_name','member_activities.date','member_activities.no_of_hour','member_activities.point','member_activities.mile')
                ->leftjoin('users','member_activities.advisorid', '=', 'users.id')
                ->leftjoin('activity_categories','member_activities.type_of_activityid', '=', 'activity_categories.id')
                 ->where('member_activities.memberid', $id)
                 ->orderBy('member_activities.activityid', 'desc')
                 ->paginate(15);
        
        $memberInfo = DB::table('members')
        ->select('id', 'first_name','last_name')
        ->Where('id', $id)
        ->get()
        ->first();
                 

        return view('member-activity-list', ['activityInfo' => $activityInfo, 'memberInfo' => $memberInfo]);
    }

    public function getMemberActivity($id)
    {   
        $typeOfActivityList = TypeOfActivity::all();

        $memberInfo = DB::table('members')
                 ->select('id', 'first_name','last_name')
                 ->Where('id', $id)
                 ->get()
                 ->first();

        return view('create-member-activity', ['typeOfActivityList' => $typeOfActivityList, 'memberInfo' => $memberInfo]);
    }

    public function create(Request $request){
        $this->validate($request, [
            'type_of_activityid' => 'required',
            'note' => 'max:500',
            'date' => 'required', 'date',
            'no_of_hour' => 'numeric|max:1000',
            'point' => 'numeric|max:1000',
            'mile' => 'numeric|max:1000'
        ]);

        MemberActivity::create([
            'type_of_activityid' => $request['type_of_activityid'],
            'activity' => $request['activity'],
            'note' => $request['note'],
            'advisorid' => $request['advisor'],
            'date' => $request['date'],
            'memberid' => $request['memberid'],
            'no_of_hour' => $request['no_of_hour'],
            'point' => $request['point'],
            'mile' => $request['mile']
            ]); 

            $activityLog = DB::table('activity_categories')->where('id', $request->type_of_activityid)->first();
            LogActivity::log('Create', "Create member activity on member $request->memberid with activity: $activityLog->activity", $request->memberid);

        return redirect()->back()->with("success","Member activity successfully added.");
    }
}
