<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment; 
use App\Models\Position;
use App\Http\Controllers\MemberActivityController;


class MemberController extends Controller
{
    public function getMemberProfileInformation($id)
    {
        $member = DB::table('members')->where('id', $id)->first();  
       // $payment = DB::table('fees')->where('jurisdiction_id', $member->jurisdiction_id)->where('chapter_id', $member->chapter_id)->get();

        //$payment = DB::table('payments')->join('fees', 'payments.fee_id', '=', 'fees.id')->where('payments.member_id', $member->id)->get();//->orderBy('payment_date', $direction='desc'); 
        $payment = DB::table('payments')
                        ->select('payments.payment_date', 'payments.amount_paid', 'fee_descriptions.description', 'fees.amount',
                        'payments.amount_outstanding')
                        ->join('fees', 'payments.fee_id', '=', 'fees.id')
                        ->join('fee_descriptions', 'fees.description_id', '=', 'fee_descriptions.id')
                        ->where('payments.member_id', $member->id)
                        ->get();
       
        //$guardians = DB::table('guardians')->where('member_id', $member->id)->get(); 
        $position = DB::table('positions')->where('id', $member->position_id)->pluck('position_name')->first(); 

        $activity = DB::table('member_activities')
            ->join('activity_categories', 'member_activities.type_of_activityid', '=', 'activity_categories.id')
            ->where('memberid', $member->id) 
            ->get();  
           
           
            $meritbadges = DB::select('SELECT activity_categories.activity as activity, max(merit_bar_records.merit_bar_id) as maxmeritbar FROM `merit_bar_records` inner join activity_categories on merit_bar_records.activity_id = activity_categories.id where member_id = ? group by merit_bar_records.activity_id, activity_categories.activity order by  merit_bar_records.activity_id', [$member->id]);
            

            $merits[] = ['Activity', 'Merit Badges'];
            if($meritbadges == null)
            {
                $merits = null;
            } 
            else
            {
            //array_unshift($meritbadges, ['Activity', 'Merit Badge']); 
          
       
        //$merits = array_push($merits, ['Activity', 'Merit Badge']);
        for($i = 0; $i < count($meritbadges); $i++)
        {
           
            $merits[$i +1] =  array(strval($meritbadges[$i]->activity), $meritbadges[$i]->maxmeritbar); 
            
        }  

       
        }
        $nominations = DB::table('nominations')->join('nomination_awards', 'nomination_awards.id', '=', 'nominations.award_id')->where('member_id',$member->id)->get();  

        //print($nominations);
    
        return view('member.memberprofile', ['member'=>$member, 'payments'=>$payment, 'activities'=>$activity, 'meritbadges'=>json_encode($merits), 'position'=>$position, 'nominations'=> $nominations]);
    

    
           
    } 

    function determineMeritBars($results) 
    {   
        $awards = ['White', 'Red', 'Blue', 'Purple', 'Gold']; 

        if($results[0]['count'] < 0)
        {
            if($results[0]['count'] >=6)
            {

            }
            if($results[0]['count'] >=12)
            {
                
            }
            if($results[0]['count'] >=18)
            {
                
            }
            if($results[0]['count'] >=24)
            {
                
            }
            if($results[0]['count'] >=30)
            {
                
            } 
        } 
        
    } 

    function buildMeritBarList($id)
    {
        $listOfCategories = DB::table('activity_categories')->get(); 
        $listOfMerits = DB::table('member_activities')
        ->select('type_of_activityid', DB::raw('COUNT(member_activities.type_of_activityid) as mycount'))
        ->where('member_activities.memberid', $id)
        ->groupBy('member_activities.type_of_activityid')
        ->orderBy('member_activities.type_of_activityid')
        ->get(); 
 
        $listOfMerits = $listOfMerits->keyBy('type_of_activityid');

        $results = [];

        foreach($listOfCategories as $item) 
        {   
            $count = 0;
            foreach($listOfMerits as $mitem)
            {   
                
                if($item->id == $mitem->type_of_activityid)
                {   
                    $count = $mitem->mycount;
                }  
            }
            $data = ['id'=>$item->id, 'name'=>$item->activity, 'count'=>$count]; 
            array_push($results,$data);
            
        }
        foreach(range(0, count($results)-1) as $item)
        {
            print('{'.$results[$item]['id'].' '.$results[$item]['name'].' '.$results[$item]['count'].'}, ');
        } 
    }

    
}
