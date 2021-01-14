<?php

namespace App\Http\Controllers;

use App\Models\Jurisdiction;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Chapter;
use App\Models\NominationAward;
use App\Models\Position;
use App\Models\Nomination;
use App\Helpers\LogActivity;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NominationController extends Controller
{ 

    public function index($id = null)
    {   
        $awards = DB::table('nomination_awards')->get(); 
        $member = Member::where('id', $id)->first();  

        if($member == null)
        {
            $member = new Member();
        } 

        $search = null;

        return view('nomination', ['member'=>$member, 'awards'=>$awards, 'search'=>$search]); 
        
    } 

    public function findMember(Request $req)
    {   
        $advisor = Position::where('position_name', 'Advisor')->first();
        $search = Member::select('id', 'first_name', 'last_name')->where('position_id', $advisor->id)->where('first_name', 'LIKE', "%{$req->fullname}%")->OrWhere('last_name', 'LIKE', "%{$req->fullname}%")->get();
        $member = new Member();  
        $awards = DB::table('nomination_awards')->get(); 
        return view('nomination', ['search'=>$search, 'member'=>$member, 'awards'=>$awards]);
    } 

    public function addNomination(Request $req)
    {       
        $nominationExist = Nomination::where('member_id', $req->memberid )->where('award_id', $req->honor)->where('date_awarded', $req->dateawarded)->count();
        if($req->honor == 0)
        {
            return back()->withInput()->with('error', 'Please select a Honor Nomination');
        } 
        else if($nominationExist > 0)
        {
            return back()->withInput()->with('error', 'This nomination already exists on the specified date for this person');
        }
        else
        {
        $nomination = new Nomination(); 
        $nomination->member_id = $req->memberid; 
        $nomination->award_id = $req->honor; 
        $nomination->date_awarded = $req->dateawarded; 
        $nomination->save();  

        LogActivity::log('Create', "Created nomination for member: $req->memberid"); 
        return back()->withInput()->with('success', 'Honor nomination successfully recorded');
        }
    }
}
