<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Support\Carbon; 
//use DataTables; 

class ReportingController extends Controller
{
    // 

    public function index()
    {  
        $paymentInformation = $this->getPaymentInformation(); 
        $groupedPaymentInformation = $this->getPaymentInformationByMember(); 
        //print(Auth::user()->roles->role_permissions_id);
        return view('reports.chapterreport', ['paymentInformation'=>$paymentInformation, 'groupedPaymentInformation'=>$groupedPaymentInformation]);
    }

    public function getPaymentInformation()
    {   
        
        $chapter = Auth::User()->chapter_id; 
        $jurisdiction = Auth::User()->jurisdiction_id; 
       

        if($chapter != null)
        {
            $payments = DB::table('payments')
            ->join('members', 'payments.member_id', '=', 'members.id')
            ->select('first_name', 'last_name', 'amount_payed', 'description', 'payment_date')
            ->where('chapter_id', $chapter) 
            ->where('jurisdiction', $jurisdiction)
            ->get(); 
        }   
        else
        {
            $payments = null;     
        }
       return $payments;
    }  

    public function getPaymentInformationByMember()
    {
        $chapter = Auth::User()->chapter_id;   
        $jurisdiction = Auth::User()->jurisdiction_id;

        $payments = DB::table('payments')
                    ->join('members', 'payments.member_id', '=', 'members.id')  
                    ->select(DB::raw('first_name, last_name, SUM(amount_payed) as amount_payed, max(payment_date) as payment_date'))  
                    ->where('chapter_id', $chapter) 
                    ->where('jurisdiction', $jurisdiction) 
                    ->groupBy('member_id')
                    ->get(); 

            return $payments;
    }


}
