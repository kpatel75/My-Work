<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MemberListExport;

class ExcelMemberListController extends Controller
{
    // function index()
    // {
    //     $member_data = DB::table('members')->get();
    //     return view('memberlistreport')->with('member_data', $member_data);
    // }

    function excel()
    {
     return Excel::download(new MemberListExport, Date("Y_m_d") . 'MembersList.xlsx');
    }
}
