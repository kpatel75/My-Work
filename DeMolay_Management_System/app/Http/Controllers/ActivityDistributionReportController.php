<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class ActivityDistributionReportController extends Controller
{
    public function index(){
        
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $chapterid = Auth::user()->chapter_id;

        $chapter_count = DB::table('member_activities')
        ->join('members','members.id','=','member_activities.memberid')
        ->join('activity_categories','activity_categories.id','=','member_activities.type_of_activityid')
         ->select(
             DB::raw('activity_categories.id as activity'),
             DB::raw('count(member_activities.activityid) as members')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('members.jurisdiction_id', '=', $jurisdictionid);})
         ->where(function ($cquery) use ($chapterid){
            $cquery->where('members.chapter_id', '=', $chapterid);})
         ->groupby('activity_categories.id')
         ->get();

         $jurisdiction_count = DB::table('member_activities')
         ->join('members','members.id','=','member_activities.memberid')
         ->join('activity_categories','activity_categories.id','=','member_activities.type_of_activityid')
          ->select(
              DB::raw('activity_categories.id as activity'),
              DB::raw('count(member_activities.activityid) as members')
          )
          ->where(function ($jquery) use ($jurisdictionid){
             $jquery->where('members.jurisdiction_id', '=', $jurisdictionid);})
          ->groupby('activity_categories.id')
          ->get();

         $country_count = DB::table('member_activities')
         ->join('members','members.id','=','member_activities.memberid')
         ->join('activity_categories','activity_categories.id','=','member_activities.type_of_activityid')
          ->select(
              DB::raw('activity_categories.id as activity'),
              DB::raw('count(member_activities.activityid) as members')
          )
          ->groupby('activity_categories.id')
          ->get();

        $activity_list = DB::table('activity_categories')
         ->select(
             DB::raw('activity as activity'),
         )
         ->get();


        //REST LIST TO 0
        $chapter_list = array();
        $jurisdiction_list = array();
        $country_list = array();
         $y=0;
         foreach ($activity_list as $data) 
         {
             $y++;
             ${'c'.$y} = 0;
             ${'j'.$y} = 0;
             ${'co'.$y} = 0;

             array_push($chapter_list,${'c'.$y});
             array_push($jurisdiction_list,${'c'.$y});
             array_push($country_list,${'c'.$y});

         };

            //CHAPTER AGE COUNTS
            $x=0;
         foreach ($chapter_count as $data) 
         {
            $x=$data->activity;
            $chapter_list[$x-1] = $data->members;
         };

          //JURISDICTION AGE COUNTS
          $x=0;
          foreach ($jurisdiction_count as $data) 
          {
            $x=$data->activity;
            $jurisdiction_list[$x-1] = $data->members;
          };

           //COUNTRY AGE COUNTS
           $x=0;
           foreach ($country_count as $data) 
           {
            $x=$data->activity;
            $country_list[$x-1] = $data->members;
           };

        
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


        return view('reports.activitydistributionreport')->with('chapter_list', $chapter_list)->with('jurisdiction_list', $jurisdiction_list)->with('country_list', $country_list)->with('chapter_name', $chapter_name)->with('jurisdiction_name', $jurisdiction_name)->with('activity_list', $activity_list);

    }

    public function createPDF() {
        // retreive all records from db
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $chapterid = Auth::user()->chapter_id;

        $chapter_count = DB::table('member_activities')
        ->join('members','members.id','=','member_activities.memberid')
        ->join('activity_categories','activity_categories.id','=','member_activities.type_of_activityid')
         ->select(
             DB::raw('activity_categories.id as activity'),
             DB::raw('count(member_activities.activityid) as members')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('members.jurisdiction_id', '=', $jurisdictionid);})
         ->where(function ($cquery) use ($chapterid){
            $cquery->where('members.chapter_id', '=', $chapterid);})
         ->groupby('activity_categories.id')
         ->get();

         $jurisdiction_count = DB::table('member_activities')
         ->join('members','members.id','=','member_activities.memberid')
         ->join('activity_categories','activity_categories.id','=','member_activities.type_of_activityid')
          ->select(
              DB::raw('activity_categories.id as activity'),
              DB::raw('count(member_activities.activityid) as members')
          )
          ->where(function ($jquery) use ($jurisdictionid){
             $jquery->where('members.jurisdiction_id', '=', $jurisdictionid);})
          ->groupby('activity_categories.id')
          ->get();

         $country_count = DB::table('member_activities')
         ->join('members','members.id','=','member_activities.memberid')
         ->join('activity_categories','activity_categories.id','=','member_activities.type_of_activityid')
          ->select(
              DB::raw('activity_categories.id as activity'),
              DB::raw('count(member_activities.activityid) as members')
          )
          ->groupby('activity_categories.id')
          ->get();

        $activity_list = DB::table('activity_categories')
         ->select(
             DB::raw('activity as activity'),
         )
         ->get();


        //REST LIST TO 0
        $chapter_list = array();
        $jurisdiction_list = array();
        $country_list = array();
         $y=0;
         foreach ($activity_list as $data) 
         {
             $y++;
             ${'c'.$y} = 0;
             ${'j'.$y} = 0;
             ${'co'.$y} = 0;

             array_push($chapter_list,${'c'.$y});
             array_push($jurisdiction_list,${'c'.$y});
             array_push($country_list,${'c'.$y});

         };

            //CHAPTER AGE COUNTS
            $x=0;
         foreach ($chapter_count as $data) 
         {
            $x=$data->activity;
            $chapter_list[$x-1] = $data->members;
         };

          //JURISDICTION AGE COUNTS
          $x=0;
          foreach ($jurisdiction_count as $data) 
          {
            $x=$data->activity;
            $jurisdiction_list[$x-1] = $data->members;
          };

           //COUNTRY AGE COUNTS
           $x=0;
           foreach ($country_count as $data) 
           {
            $x=$data->activity;
            $country_list[$x-1] = $data->members;
           };

        //GET NAMES OF JURISDICTION AND CHAPTER
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
  
        // share data to view
        $pdf = PDF::loadView('reports.activitydistributionreportpdf', compact('chapter_list','jurisdiction_list','country_list','chapter_name','jurisdiction_name','activity_list'))->setPaper('a4', 'landscape');;
  
        // download PDF file with download method
        if(Auth::user()->chapter_id == null)
        {
            $pdfchapter = "";
        }
        else
        {
            $pdfchapter = Auth::user()->chapter_id;
        }
        $pdfName = date("Y_m_d") . "age_distribution_report_chapter_" . $pdfchapter . ".pdf";
        return $pdf->download($pdfName);
      }


}
