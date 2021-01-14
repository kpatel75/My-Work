<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function membersByAge()
    {
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $chapterid = Auth::user()->chapter_id;
        $position1 = 11;
        $status1 = "Abandoned";
        $status2 = "Inactive";

        //Country level members by province (bar graph)
        $data = DB::table('members')
        ->join('jurisdictions','members.jurisdiction_id','=','jurisdictions.id')
                ->select(
                    DB::raw('jurisdictions.description as province'),
                    DB::raw('count(*) as members'))
                    ->where(function ($cquery) use ($position1){
                        $cquery->where('position_id', '<=', $position1);})
                    ->where(function ($cquery) use ($status1){
                        $cquery->where('status', '<>', $status1);})
                    ->where(function ($cquery) use ($status2){
                        $cquery->where('status', '<>', $status2);})
                ->groupby('jurisdictions.description')
        ->get();
        $memberByProvinceCountry[] = ['Province', 'Members'];
        foreach ($data as $index => $value) {
            $memberByProvinceCountry[++$index] = [strval($value->province), $value->members];
        }
        // Country level members by age (pie chart)
        $data = DB::table('members')
        ->select(
            DB::raw(' DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),birthdate)), \'%Y\')+0 AS age'),
            DB::raw('count(*) as members')
        )
        ->where(function ($cquery) use ($position1){
            $cquery->where('position_id', '<=', $position1);})
        ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
        ->groupby('age')
        ->orderBy('age')
            ->get();
        $membersByAgeCountry[] = ['Age', 'Members'];
        foreach ($data as $index => $value) {
            $membersByAgeCountry[++$index] = [strval($value->age), $value->members];
        }

        //Jurisdiction level members by chapter (bar graph)
        $data= DB::table('members')
        ->join('chapters','members.chapter_id','=','chapters.id')
        ->select(
            DB::raw('chapters.description as chapter'),
            DB::raw('count(members.id) as members')
        )
        ->where(function ($query) use ($jurisdictionid) {
            $query->where('members.jurisdiction_id', '=', $jurisdictionid);})
        ->whereRaw('members.jurisdiction_id = chapters.jurisdiction_id')
        ->where(function ($cquery) use ($position1){
            $cquery->where('position_id', '<=', $position1);})
        ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
        ->groupby('chapters.description')
        ->get();

        $memberByChapterJurisdiction[] = ['Chapter', 'Members'];
        foreach ($data as $index => $value) {
            $memberByChapterJurisdiction[++$index] = [strval($value->chapter), $value->members];
        }
        // Jurisdiction level members by age (pie chart)
        $data = DB::table('members')
        ->select(
            DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(now(),birthdate)), \'%y %m %d\')+0 AS age'),
            DB::raw('count(*) as members')
        )
        ->where(function ($query) use ($jurisdictionid) {
            $query->where('jurisdiction_id', '=', $jurisdictionid);})
            ->where(function ($cquery) use ($position1){
                $cquery->where('position_id', '<=', $position1);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
        ->groupby('age')
        ->orderBy('age')
        ->get();

        $membersByAgeJurisdiction[] = ['Age', 'Members'];
        foreach ($data as $index => $value) {
            $membersByAgeJurisdiction[++$index] = [strval($value->age), $value->members];
        }

         // Chapter level members by age (pie chart)
         $data = DB::table('members')
         ->select(
             DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,birthdate)), \'%Y\')+0 AS age'),
             DB::raw('count(*) as members')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
         ->where(function ($cquery) use ($chapterid){
            $cquery->where('chapter_id', '=', $chapterid);})
            ->where(function ($cquery) use ($position1){
                $cquery->where('position_id', '<=', $position1);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
         ->groupby('age')
         ->orderBy('age')
         ->get();
 
         $membersByAgeChapter[] = ['Age', 'Members'];
         foreach ($data as $index => $value) {
             $membersByAgeChapter[++$index] = [strval($value->age), $value->members];
         }

        return view('home')->with('membersByProvinceCountry', json_encode($memberByProvinceCountry))->with('membersByAgeCountry', json_encode($membersByAgeCountry))->with('memberByChapterJurisdiction', json_encode($memberByChapterJurisdiction))->with('membersByAgeJurisdiction', json_encode($membersByAgeJurisdiction))->with('membersByAgeChapter', json_encode($membersByAgeChapter));
    }
}