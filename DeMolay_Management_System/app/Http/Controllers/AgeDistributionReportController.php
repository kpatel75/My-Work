<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class AgeDistributionReportController extends Controller
{
    public function index(){
        
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $chapterid = Auth::user()->chapter_id;
        $position1 = 11;
        $status1 = "Abandoned";
        $status2 = "Inactive";

        $chapter_count = DB::table('members')
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
         ->get();

         $jurisdiction_count = DB::table('members')
         ->select(
             DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,birthdate)), \'%Y\')+0 AS age'),
             DB::raw('count(*) as members')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
            ->where(function ($cquery) use ($position1){
                $cquery->where('position_id', '<=', $position1);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
         ->groupby('age')
         ->get();

         $country_count = DB::table('members')
         ->select(
             DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,birthdate)), \'%Y\')+0 AS age'),
             DB::raw('count(*) as members')
         )
         ->where(function ($cquery) use ($position1){
            $cquery->where('position_id', '<=', $position1);})
        ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
         ->groupby('age')
         ->get();

            //CHAPTER AGE COUNTS
            $c8=0;
            $c22=0;
         foreach ($chapter_count as $data) {
             if($data->age<10){
                 $c8 = $c8 + $data->members;
             }elseif ($data->age == 10) {
                $c10 = $data->members;
            } elseif ($data->age == 11) {
                $c11 = $data->members;
            } elseif ($data->age == 12) {
                $c12 = $data->members;
            } elseif ($data->age == 13) {
                $c13 = $data->members;
            } elseif ($data->age == 14) {
                $c14 = $data->members;
            } elseif ($data->age == 15) {
                $c15 = $data->members;
            } elseif ($data->age == 16) {
                $c16 = $data->members;
            } elseif ($data->age == 17) {
                $c17 = $data->members;
            } elseif ($data->age == 18) {
                $c18 = $data->members;
            } elseif ($data->age == 19) {
                $c19 = $data->members;
            } elseif ($data->age == 20) {
                $c20 = $data->members;
            } elseif ($data->age == 21) {
                $c21 = $data->members;
            }
            elseif ($data->age > 21) {
                $c22 = $c22 + $data->members;
            }
        };

        if(empty($c10))
        {
            $c10 = 0;
        }
        if(empty($c11))
        {
            $c11 = 0;
        }
        if(empty($c12))
        {
            $c12 = 0;
        }
        if(empty($c13))
        {
            $c13 = 0;
        }
        if(empty($c14))
        {
            $c14 = 0;
        }
        if(empty($c15))
        {
            $c15 = 0;
        }
        if(empty($c16))
        {
            $c16 = 0;
        }
        if(empty($c17))
        {
            $c17 = 0;
        }
        if(empty($c18))
        {
            $c18 = 0;
        }
        if(empty($c19))
        {
            $c19 = 0;
        }
        if(empty($c20))
        {
            $c20 = 0;
        }
        if(empty($c21))
        {
            $c21 = 0;
        }

        //JURISDICTION AGE COUNTS
        $j8=0;
        $j22=0;
        foreach ($jurisdiction_count as $data) {
            if($data->age<10){
                $j8 = $j8 + $data->members;
            }elseif ($data->age == 10) {
                $j10 = $data->members;
            } elseif ($data->age == 11) {
                $j11 = $data->members;
            } elseif ($data->age == 12) {
                $j12 = $data->members;
            } elseif ($data->age == 13) {
                $j13 = $data->members;
            } elseif ($data->age == 14) {
                $j14 = $data->members;
            } elseif ($data->age == 15) {
                $j15 = $data->members;
            } elseif ($data->age == 16) {
                $j16 = $data->members;
            } elseif ($data->age == 17) {
                $j17 = $data->members;
            } elseif ($data->age == 18) {
                $j18 = $data->members;
            } elseif ($data->age == 19) {
                $j19 = $data->members;
            } elseif ($data->age == 20) {
                $j20 = $data->members;
            } elseif ($data->age == 21) {
                $j21 = $data->members;
            }
            elseif ($data->age > 21) {
                $j22 = $j22 + $data->members;
            }
        };

        if(empty($j10))
        {
            $j10 = 0;
        }
        if(empty($j11))
        {
            $j11 = 0;
        }
        if(empty($j12))
        {
            $j12 = 0;
        }
        if(empty($j13))
        {
            $j13 = 0;
        }
        if(empty($j14))
        {
            $j14 = 0;
        }
        if(empty($j15))
        {
            $j15 = 0;
        }
        if(empty($j16))
        {
            $j16 = 0;
        }
        if(empty($j17))
        {
            $j17 = 0;
        }
        if(empty($j18))
        {
            $j18 = 0;
        }
        if(empty($j19))
        {
            $j19 = 0;
        }
        if(empty($j20))
        {
            $j20 = 0;
        }
        if(empty($j21))
        {
            $j21 = 0;
        }

        //COUNTRY AGE COUNTS
        $co8=0;
        $co22=0;
        foreach ($country_count as $data) {
            if($data->age<10){
                $co8 = $co8 + $data->members;
            }elseif ($data->age == 10) {
                $co10 = $data->members;
            } elseif ($data->age == 11) {
                $co11 = $data->members;
            } elseif ($data->age == 12) {
                $co12 = $data->members;
            } elseif ($data->age == 13) {
                $co13 = $data->members;
            } elseif ($data->age == 14) {
                $co14 = $data->members;
            } elseif ($data->age == 15) {
                $co15 = $data->members;
            } elseif ($data->age == 16) {
                $co16 = $data->members;
            } elseif ($data->age == 17) {
                $co17 = $data->members;
            } elseif ($data->age == 18) {
                $co18 = $data->members;
            } elseif ($data->age == 19) {
                $co19 = $data->members;
            } elseif ($data->age == 20) {
                $co20 = $data->members;
            } elseif ($data->age == 21) {
                $co21 = $data->members;
            }elseif ($data->age > 21) {
                $co22 = $co22 + $data->members;
            }
        };

        if(empty($co10))
        {
            $co10 = 0;
        }
        if(empty($co11))
        {
            $co11 = 0;
        }
        if(empty($co12))
        {
            $co12 = 0;
        }
        if(empty($co13))
        {
            $co13 = 0;
        }
        if(empty($co14))
        {
            $co14 = 0;
        }
        if(empty($co15))
        {
            $co15 = 0;
        }
        if(empty($co16))
        {
            $co16 = 0;
        }
        if(empty($co17))
        {
            $co17 = 0;
        }
        if(empty($co18))
        {
            $co18 = 0;
        }
        if(empty($co19))
        {
            $co19 = 0;
        }
        if(empty($co20))
        {
            $co20 = 0;
        }
        if(empty($co21))
        {
            $co21 = 0;
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

         return view('reports.agedistributionreport')->with('c8',$c8)->with('c10',$c10)->with('c11',$c11)->with('c12',$c12)->with('c13',$c13)->with('c14',$c14)->with('c15',$c15)->with('c16',$c16)->with('c17',$c17)->with('c18',$c18)->with('c19',$c19)->with('c20',$c20)->with('c21', $c21)->with('c22',$c22)->with('j8',$j8)->with('j10',$j10)->with('j11',$j11)->with('j12',$j12)->with('j13',$j13)->with('j14',$j14)->with('j15',$j15)->with('j16',$j16)->with('j17',$j17)->with('j18',$j18)->with('j19',$j19)->with('j20',$j20)->with('j21', $j21)->with('j22',$j22)->with('co8',$co8)->with('co10',$co10)->with('co11',$co11)->with('co12',$co12)->with('co13',$co13)->with('co14',$co14)->with('co15',$co15)->with('co16',$co16)->with('co17',$co17)->with('co18',$co18)->with('co19',$co19)->with('co20',$co20)->with('co21', $co21)->with('co22',$co22)->with('jurisdiction_name', $jurisdiction_name)->with('chapter_name', $chapter_name);

    }

    public function createPDF() {
        // retreive all records from db
        $jurisdictionid = Auth::user()->jurisdiction_id;
        $chapterid = Auth::user()->chapter_id;

        $position1 = 11;
        $status1 = "Abandoned";
        $status2 = "Inactive";

        $chapter_count = DB::table('members')
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
         ->get();

         $jurisdiction_count = DB::table('members')
         ->select(
             DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,birthdate)), \'%Y\')+0 AS age'),
             DB::raw('count(*) as members')
         )
         ->where(function ($jquery) use ($jurisdictionid){
            $jquery->where('jurisdiction_id', '=', $jurisdictionid);})
            ->where(function ($cquery) use ($position1){
                $cquery->where('position_id', '<=', $position1);})
            ->where(function ($cquery) use ($status1){
                $cquery->where('status', '<>', $status1);})
            ->where(function ($cquery) use ($status2){
                $cquery->where('status', '<>', $status2);})
         ->groupby('age')
         ->get();

         $country_count = DB::table('members')
         ->select(
             DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(CURRENT_DATE,birthdate)), \'%Y\')+0 AS age'),
             DB::raw('count(*) as members')
         )
         ->where(function ($cquery) use ($position1){
            $cquery->where('position_id', '<=', $position1);})
        ->where(function ($cquery) use ($status1){
            $cquery->where('status', '<>', $status1);})
        ->where(function ($cquery) use ($status2){
            $cquery->where('status', '<>', $status2);})
         ->groupby('age')
         ->get();

            //CHAPTER AGE COUNTS
            $c8=0;
            $c22=0;
         foreach ($chapter_count as $data) {
             if($data->age<10){
                 $c8 = $c8 + $data->members;
             }elseif ($data->age == 10) {
                $c10 = $data->members;
            } elseif ($data->age == 11) {
                $c11 = $data->members;
            } elseif ($data->age == 12) {
                $c12 = $data->members;
            } elseif ($data->age == 13) {
                $c13 = $data->members;
            } elseif ($data->age == 14) {
                $c14 = $data->members;
            } elseif ($data->age == 15) {
                $c15 = $data->members;
            } elseif ($data->age == 16) {
                $c16 = $data->members;
            } elseif ($data->age == 17) {
                $c17 = $data->members;
            } elseif ($data->age == 18) {
                $c18 = $data->members;
            } elseif ($data->age == 19) {
                $c19 = $data->members;
            } elseif ($data->age == 20) {
                $c20 = $data->members;
            } elseif ($data->age == 21) {
                $c21 = $data->members;
            }
            elseif ($data->age > 21) {
                $c22 = $c22 + $data->members;
            }
        };

        if(empty($c10))
        {
            $c10 = 0;
        }
        if(empty($c11))
        {
            $c11 = 0;
        }
        if(empty($c12))
        {
            $c12 = 0;
        }
        if(empty($c13))
        {
            $c13 = 0;
        }
        if(empty($c14))
        {
            $c14 = 0;
        }
        if(empty($c15))
        {
            $c15 = 0;
        }
        if(empty($c16))
        {
            $c16 = 0;
        }
        if(empty($c17))
        {
            $c17 = 0;
        }
        if(empty($c18))
        {
            $c18 = 0;
        }
        if(empty($c19))
        {
            $c19 = 0;
        }
        if(empty($c20))
        {
            $c20 = 0;
        }
        if(empty($c21))
        {
            $c21 = 0;
        }

        //JURISDICTION AGE COUNTS
        $j8=0;
        $j22=0;
        foreach ($jurisdiction_count as $data) {
            if($data->age<10){
                $j8 = $j8 + $data->members;
            }elseif ($data->age == 10) {
                $j10 = $data->members;
            } elseif ($data->age == 11) {
                $j11 = $data->members;
            } elseif ($data->age == 12) {
                $j12 = $data->members;
            } elseif ($data->age == 13) {
                $j13 = $data->members;
            } elseif ($data->age == 14) {
                $j14 = $data->members;
            } elseif ($data->age == 15) {
                $j15 = $data->members;
            } elseif ($data->age == 16) {
                $j16 = $data->members;
            } elseif ($data->age == 17) {
                $j17 = $data->members;
            } elseif ($data->age == 18) {
                $j18 = $data->members;
            } elseif ($data->age == 19) {
                $j19 = $data->members;
            } elseif ($data->age == 20) {
                $j20 = $data->members;
            } elseif ($data->age == 21) {
                $j21 = $data->members;
            }
            elseif ($data->age > 21) {
                $j22 = $j22 + $data->members;
            }
        };

        if(empty($j10))
        {
            $j10 = 0;
        }
        if(empty($j11))
        {
            $j11 = 0;
        }
        if(empty($j12))
        {
            $j12 = 0;
        }
        if(empty($j13))
        {
            $j13 = 0;
        }
        if(empty($j14))
        {
            $j14 = 0;
        }
        if(empty($j15))
        {
            $j15 = 0;
        }
        if(empty($j16))
        {
            $j16 = 0;
        }
        if(empty($j17))
        {
            $j17 = 0;
        }
        if(empty($j18))
        {
            $j18 = 0;
        }
        if(empty($j19))
        {
            $j19 = 0;
        }
        if(empty($j20))
        {
            $j20 = 0;
        }
        if(empty($j21))
        {
            $j21 = 0;
        }

        //COUNTRY AGE COUNTS
        $co8=0;
        $co22=0;
        foreach ($country_count as $data) {
            if($data->age<10){
                $co8 = $co8 + $data->members;
            }elseif ($data->age == 10) {
                $co10 = $data->members;
            } elseif ($data->age == 11) {
                $co11 = $data->members;
            } elseif ($data->age == 12) {
                $co12 = $data->members;
            } elseif ($data->age == 13) {
                $co13 = $data->members;
            } elseif ($data->age == 14) {
                $co14 = $data->members;
            } elseif ($data->age == 15) {
                $co15 = $data->members;
            } elseif ($data->age == 16) {
                $co16 = $data->members;
            } elseif ($data->age == 17) {
                $co17 = $data->members;
            } elseif ($data->age == 18) {
                $co18 = $data->members;
            } elseif ($data->age == 19) {
                $co19 = $data->members;
            } elseif ($data->age == 20) {
                $co20 = $data->members;
            } elseif ($data->age == 21) {
                $co21 = $data->members;
            }elseif ($data->age > 21) {
                $co22 = $co22 + $data->members;
            }
        };

        if(empty($co10))
        {
            $co10 = 0;
        }
        if(empty($co11))
        {
            $co11 = 0;
        }
        if(empty($co12))
        {
            $co12 = 0;
        }
        if(empty($co13))
        {
            $co13 = 0;
        }
        if(empty($co14))
        {
            $co14 = 0;
        }
        if(empty($co15))
        {
            $co15 = 0;
        }
        if(empty($co16))
        {
            $co16 = 0;
        }
        if(empty($co17))
        {
            $co17 = 0;
        }
        if(empty($co18))
        {
            $co18 = 0;
        }
        if(empty($co19))
        {
            $co19 = 0;
        }
        if(empty($co20))
        {
            $co20 = 0;
        }
        if(empty($co21))
        {
            $co21 = 0;
        }

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
        $pdf = PDF::loadView('reports.agedistributionreportpdf', compact('c8','c10','c11','c12','c13','c14','c15','c16','c17','c18','c19','c20','c21','c22','j8','j10','j11','j12','j13','j14','j15','j16','j17','j18','j19','j20','j21','j22','co8','co10','co11','co12','co13','co14','co15','co16','co17','co18','co19','co20','co21','co22','chapter_name','jurisdiction_name'));
  
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
