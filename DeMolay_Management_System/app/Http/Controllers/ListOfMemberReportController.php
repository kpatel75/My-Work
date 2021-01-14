<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class ListOfMemberReportController extends Controller
{
    public function index(){
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $status1 = "Abandoned";
        $status2 = "Inactive";

        if($jurisdictionid == 0)
        {
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
         ->orderBy('position')
         ->get();
        }
        elseif(Auth::user()->chapter_id == null)
        {
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->orderBy('position')
         ->get();
        }
        else
        {
            $chapterid = Auth::user()->chapter_id;
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
         ->where(function ($cquery) use ($chapterid){
            $cquery->where('chapter_id', '=', $chapterid);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->orderBy('position')
         ->get();
        }

        $jurisdiction_name=DB::table('jurisdictions')
            ->select(
                DB::raw('description')
            )
            ->where(function ($jquery) use ($jurisdictionid) {
                $jquery->where('id', '=', $jurisdictionid);
            })
            ->get();
        if(Auth::user()->chapter_id == null)
        {
            $chapter_name= "NONE";
        }
        else{
            $chapter_name=DB::table('chapters')
            ->select(
                DB::raw('description')
            )
            ->where(function ($jquery) use ($jurisdictionid){
                $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
             ->where(function ($cquery) use ($chapterid){
                $cquery->where('id', '=', $chapterid);
            })
            ->get();
        }

        if($jurisdictionid == 0)
        {
            $jurisdiction_count = DB::table('members')
        ->select(
            DB::raw('COUNT(id) as count')
        )
        ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
            ->get();

        }
        else{
            $jurisdiction_count = DB::table('members')
        ->select(
            DB::raw('COUNT(id) as count')
        )
            ->where(function ($jquery) use ($jurisdictionid) {
                $jquery->where('jurisdiction_id', '=', $jurisdictionid);
            })
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->get();
        }

        if (Auth::user()->chapter_id == null) {
            $chapter_count = "NONE";
        } 
        else {
            $chapter_count = DB::table('members')
            ->select(
                DB::raw('COUNT(id) as count')
            )
                ->where(function ($jquery) use ($jurisdictionid) {
                    $jquery->where('jurisdiction_id', '=', $jurisdictionid);
                })
                ->where(function ($cquery) use ($chapterid) {
                    $cquery->where('chapter_id', '=', $chapterid);
                })
                ->where(function ($cquery) use ($status1){
                    $cquery->where('status', '<>', $status1);})
                ->where(function ($cquery) use ($status2){
                    $cquery->where('status', '<>', $status2);})
                ->get();
            }

        return view('reports.listofmemberreport')->with('member_data',$member_data)->with('jurisdiction_name',$jurisdiction_name)->with('chapter_name',$chapter_name)->with('jurisdiction_count',$jurisdiction_count)->with('chapter_count',$chapter_count);
    }

    public function createPDF() {
        // retreive all records from db
        $status1 = "Abandoned";
        $status2 = "Inactive";
        $jurisdictionid = Auth::user()->jurisdiction_id;
        if($jurisdictionid == 0)
        {
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
         ->orderBy('position')
         ->get();
        }
        elseif(Auth::user()->chapter_id == null)
        {
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->orderBy('position')
         ->get();
        }
        else
        {
            $chapterid = Auth::user()->chapter_id;
            $member_data = DB::table('members')
            ->join('positions','positions.id','=','members.position_id')
         ->select(
            DB::raw('CONCAT("9","-",jurisdiction_id,"-",LPAD(chapter_id,3,0),"-",LPAD(members.id,5,0)) as id'),
             DB::raw('CONCAT(last_name, " ", first_name) as name'),
             DB::raw('preferred_name as goes_by'),
             DB::raw('home_phone as home_phone'),
             DB::raw('mobile_phone as mobile_phone'),
             DB::raw('email as email'),
             DB::raw('positions.position_name as position')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
         ->where(function ($cquery) use ($chapterid){
            $cquery->where('chapter_id', '=', $chapterid);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
         ->orderBy('position')
         ->get();
        }

        $jurisdiction_name=DB::table('jurisdictions')
            ->select(
                DB::raw('description')
            )
            ->where(function ($jquery) use ($jurisdictionid) {
                $jquery->where('id', '=', $jurisdictionid);
            })
            ->get();
        if(Auth::user()->chapter_id == null)
        {
            $chapter_name= "NONE";
        }
        else{
            $chapter_name=DB::table('chapters')
            ->select(
                DB::raw('description')
            )
            ->where(function ($jquery) use ($jurisdictionid){
                $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
             ->where(function ($cquery) use ($chapterid){
                $cquery->where('id', '=', $chapterid);
            })
            ->get();
        }

        if($jurisdictionid == 0)
        {
            $jurisdiction_count = DB::table('members')
        ->select(
            DB::raw('COUNT(id) as count')
        )
        ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
            ->get();

        }
        else{
            $jurisdiction_count = DB::table('members')
        ->select(
            DB::raw('COUNT(id) as count')
        )
            ->where(function ($jquery) use ($jurisdictionid) {
                $jquery->where('jurisdiction_id', '=', $jurisdictionid);
            })
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
            ->get();
        }

        if (Auth::user()->chapter_id == null) {
            $chapter_count = "NONE";
        } 
        else {
            $chapter_count = DB::table('members')
            ->select(
                DB::raw('COUNT(id) as count')
            )
                ->where(function ($jquery) use ($jurisdictionid) {
                    $jquery->where('jurisdiction_id', '=', $jurisdictionid);
                })
                ->where(function ($cquery) use ($chapterid) {
                    $cquery->where('chapter_id', '=', $chapterid);
                })
                ->where(function ($cquery) use ($status1){
                    $cquery->where('status', '<>', $status1);})
                ->where(function ($cquery) use ($status2){
                    $cquery->where('status', '<>', $status2);})
                ->get();
            }
  
        // share data to view
        $pdf = PDF::loadView('reports.listofmemberreportpdf', compact('member_data','jurisdiction_name','chapter_name','jurisdiction_count','chapter_count'))->setPaper('a4', 'landscape');
  
        // download PDF file with download method
        if(Auth::user()->chapter_id == null)
        {
            $pdfchapter = "";
        }
        else
        {
            $pdfchapter = "_chapter_" . Auth::user()->chapter_id;
        }
        $pdfName = date("Y_m_d") . "age_distribution_report" . $pdfchapter . ".pdf";
        return $pdf->download($pdfName);
      }
}
